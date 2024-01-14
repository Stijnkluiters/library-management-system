@extends('layout')

@section('content')

    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Quantity</th>
            <th>Rent</th>
        </tr>
        </thead>
        <tbody>
        @foreach($books as $book)
            <tr>
                <td>{{ $book->getTitle() }}</td>
                <td>{{ $book->getQuantity() }}</td>
                <td>
                    <form action="{{ route('books.order', $book->getTitle()) }}" method="post">
                        @csrf
                        <input type="hidden" value="{{ Carbon\Carbon::now()->toDateString() }}" name="start_at"/>
                        <input type="hidden" value="{{ Carbon\Carbon::now()->addDays(3)->toDateString() }}" name="end_at"/>
                        <button name="order" value="order book" style="border: solid #4b5563">Order This Book for 3 days</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <hr/>

    <h2>
        <a href="{{ route('orders.index') }}">
            View Orders
        </a>
    </h2>
@endsection
