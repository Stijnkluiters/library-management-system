@extends('layout')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center bg-light py-3">
            <div class="col-12">
                <h2>Order : {{ $order->getUuid() }}</h2>
                @foreach($order->getOrderLines() as $orderLine)
                    <hr/>
                    <ul>
                        <li>Product Uuid: {{ $orderLine->product->getUuid() }}</li>
                        <li>Price: {{ $orderLine->product->getPrice()->toHumanReadableString() }}</li>
                        <li>Name: {{ $orderLine->product->getName() }}</li>
                        <li>Amount: {{ $orderLine->amount }}</li>
                    </ul>
                @endforeach
            </div>
        </div>
    </div>
@endsection
