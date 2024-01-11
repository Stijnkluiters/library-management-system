<?php

namespace App\Http\Controllers;

use App\Domain\_shared\ID;
use App\Domain\Orders\Infrastructure\Services\OrderService;
use Carbon\CarbonImmutable;
use DomainException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {
    }

    public function order(Request $request): Response
    {
        $start = CarbonImmutable::parse($request->get('start_at'));
        $end = CarbonImmutable::parse($request->get('end_at'));
        try {
            $this->orderService->orderBook(
                ID::createFromInt((int)$request->get('customer_id')),
                $request->get('book_title'),
                $start,
                $end
            );
        } catch (DomainException $domainException) {
            throw ValidationException::withMessages(['error' => $domainException->getMessage()]);
        }

        return new Response('Successfully ordered your book');
    }
}
