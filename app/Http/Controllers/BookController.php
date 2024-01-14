<?php

namespace App\Http\Controllers;

use App\Domain\_shared\Exceptions\DomainException;
use App\Domain\_shared\ID;
use App\Domain\Store\Domain\ValueObjects\Period;
use App\Domain\Store\Infrastructure\Services\StoreService;
use App\Domain\Store\Infrastructure\Services\BookService;
use Carbon\CarbonImmutable;
use Exception;
use Illuminate\Contracts\View\View;
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
            ->with(['message' => 'successfully order book ' . $bookTitle]);
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
