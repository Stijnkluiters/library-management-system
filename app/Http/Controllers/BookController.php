<?php

namespace App\Http\Controllers;

use App\Domain\_shared\Exceptions\DomainException;
use App\Domain\_shared\ID;
use App\Domain\Orders\Infrastructure\Services\OrderService;
use App\Domain\Stock\Infrastructure\Services\BookService;
use App\Domain\Stock\Infrastructure\Services\StockService;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    public function __construct(
        private readonly StockService $stockService,
        private readonly BookService $bookService,
    ) {
    }

    public function index(): View
    {
        $books = $this->bookService->getBooks();

        return view('books.index', compact('books'));
    }

    public function order(Request $request, string $bookTitle): RedirectResponse
    {
        $start = CarbonImmutable::parse($request->get('start_at'));
        $end = CarbonImmutable::parse($request->get('end_at'));
        try {
            $this->stockService->reduceStock(
                ID::createFromInt((int)$request->get('customer_id')),
                $bookTitle,
                $start,
                $end
            );
        } catch (DomainException $domainException) {
            throw ValidationException::withMessages(['error' => $domainException->getMessage()]);
        }

        return redirect(route('books.index'))
            ->with(['message' => 'successfully order book ' . $bookTitle]);
    }
}
