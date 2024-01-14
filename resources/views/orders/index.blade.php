@extends('layout')

@section('content')
    <table>
        <thead>
        <tr>
            <th>Book</th>
            <th>Price</th>
            <th>Rent start</th>
            <th>Rent end</th>
            <th>Returned AT</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->getBook()->getTitle() }}</td>
                <td>&euro;{{ $order->getBook()->getPrice()->toHumanReadableString() }}</td>
                <td>{{ $order->getStartAt()->toDateString() }}</td>
                <td>{{ $order->getEndAt()->toDateString() }}</td>
                <td>{{ $order->getReturnedAt()?->toDateString() }}</td>
                <td>
                    <form action="{{ route('books.return', $order->getBook()->getTitle()) }}" method="post">
                        @csrf
                        <input type="hidden" value="{{ $order->getId() }}" name="order_id"/>
                        <button name="order" value="order book" style="border: solid #4b5563">Return book</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <hr/>

    <h2>
        <a href="{{ route('books.index') }}">
            View Available Books
        </a>
    </h2>
@endsection
