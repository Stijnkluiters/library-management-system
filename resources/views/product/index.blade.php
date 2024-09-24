@extends('layout')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center bg-light py-3">
            <div class="col-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Order</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->getName() }}</td>
                            <td>{!! $product->getPrice()->toHumanReadableString() !!}</td>
                            <td>
                                <form action="{{ route('products.order', $product->getUuid()) }}" method="post">
                                    {{ csrf_field() }}
                                    <button class="btn btn-primary" name="productId" value="{{ $product->getUuid() }}">Order</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
