@extends('layout')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center bg-light py-3">
            <div class="col-12">
                <table>
                    <thead>
                        <tr>
                            <th>order-id</th>
                            <th>amount of order lines</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->getUuid() }}</td>
                            <td>{{ count($order->getOrderLines()) }}</td>
                            <td>
                                <a href="{{ route('orders.show', $order->getUuid()) }}">View</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
