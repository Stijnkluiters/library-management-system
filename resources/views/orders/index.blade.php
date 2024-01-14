@extends('layout')

@section('content')
    <table>
        <thead>
        <tr>
            <th>Book</th>
            <th>Price</th>
            <th>Rent start</th>
            <th>Rent end</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->getBook()->getTitle() }}</td>
                <td>&euro;{{ $order->getBook()->getPrice()->toHumanReadableString() }}</td>
                <td>{{ $order->getStartAt()->toDateString() }}</td>
                <td>{{ $order->getEndAt()->toDateString() }}</td>
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
