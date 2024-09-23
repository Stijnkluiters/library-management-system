@extends('layout')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center bg-light py-3">
            <div class="col-4">
                <div class="p-3 rounded text-nowrap">
                    <a href="{{ route('products.index') }}">
                        Products
                    </a>
                </div>
            </div>
            <div class="col-4">
                <div class="p-3 rounded text-nowrap">
                    <a href="{{ route('orders.index') }}">
                        Orders
                    </a>
                </div>
            </div>
            <div class="col-4">
                <div class="bg-secondary p-3 rounded text-nowrap">div c</div>
            </div>
        </div>
    </div>
@endsection
