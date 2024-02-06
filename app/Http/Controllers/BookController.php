<?php

namespace App\Http\Controllers;

use App\Domain\_shared\Exceptions\DomainException;
use App\Domain\_shared\ID;
use App\Domain\Store\Domain\ValueObjects\Period;
use App\Domain\Store\Infrastructure\Exceptions\BookAlreadyExistException;
use App\Domain\Store\Infrastructure\Services\BookService;
use App\Domain\Store\Infrastructure\Services\StoreService;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    public function __construct(
        private readonly StoreService $storeService,
        private readonly BookService $bookService,
    ) {
    }

    public function index(): View
    {
        $books = $this->bookService->getBooks();

        return view('books.index', compact('books'));
    }

    public function create(): View
    {
        return view('books.create');
    }

    public function store(BookStoreRequest $request): RedirectResponse
    {
        $bookAttributes = $request->validated();
        try {
            $book = $this->bookService->create($bookAttributes);
        } catch (BookAlreadyExistException $alreadyExistException) {
            return back()
                ->withInput()
                ->withErrors(['message' => $alreadyExistException->getMessage()]);
        }

        return redirect(route('books.index'))
            ->with(['message' => 'Successfully created book: ' . $book->getTitle()]);
    }

    public function edit(int $id): View
    {
        $book = $this->bookService->getBookById(ID::createFromInt($id));

        return view('books.edit', compact('book'));
    }

    public function update(BookUpdateRequest $bookUpdateRequest, $id): RedirectResponse
    {
        $originalBook = $this->bookService->getBookById(ID::createFromInt($id));

        try {
            $book = $this->bookService->update(
                $originalBook,
                $bookUpdateRequest->validated()
            );

            return redirect(route('books.index'))
                ->with(['message' => 'Successfully modified your book']);
        } catch (BookAlreadyExistException $alreadyExistException) {
            return back()
                ->withInput()
                ->withErrors(['message' => $alreadyExistException->getMessage()]);
        }
    }

    public function destroy(int $bookId): RedirectResponse
    {
        $this->storeService->revokeBook(ID::createFromInt($bookId));

        return redirect(route('books.index'))
            ->with(['message' => 'Successfully deleted your book.']);
    }

    public function order(Request $request, string $bookTitle)
    {
        $start = CarbonImmutable::parse($request->get('start_at'));
        $end = CarbonImmutable::parse($request->get('end_at'));
        try {
            $this->storeService->rentBook(
                $bookTitle,
                ID::createFromInt((int)$request->get('customer_id')),
                Period::make($start, $end),
            );
        } catch (DomainException $domainException) {
            throw ValidationException::withMessages(['error' => $domainException->getMessage()]);
        }

        return redirect(route('books.index'))
            ->with(['message' => 'Successfully ordered book: ' . $bookTitle]);
    }

    public function return(Request $request, string $bookTitle)
    {
        try {
            $this->storeService->returnBook(
                $bookTitle,
                ID::createFromInt((int)$request->get('order_id')),
            );
        } catch (DomainException $domainException) {
            throw ValidationException::withMessages(['error' => $domainException->getMessage()]);
        }

        return redirect(route('orders.index'))
            ->with(['message' => 'successfully returned book ' . $bookTitle]);
    }
}
