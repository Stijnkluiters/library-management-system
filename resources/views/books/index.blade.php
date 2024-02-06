@extends('layout')

@section('content')
    <h2>Books in the bookstore</h2>
    <a type="button" class="btn btn-primary" href="{{ route('books.create') }}"> Add a new book to the store </a>
    <hr/>
    @foreach($books as $book)
        @if($loop->index % 4 === 0)
            <div class="row">
        @endif
                <div class="card col-sm-6 col-lg-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->getTitle() }}</h5>
                        @if ($book->getQuantity() > 1)
                            <p class="card-text">We have {{ $book->getQuantity() }} books in stock.</p>
                        @else
                            <p class="card-text">We have {{ $book->getQuantity() }} book in stock.</p>
                        @endif
                        <a href="#" class="card-link">
                            <form action="{{ route('books.order', $book->getTitle()) }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ Carbon\Carbon::now()->toDateString() }}" name="start_at"/>
                                <input type="hidden" value="{{ Carbon\Carbon::now()->addDays(3)->toDateString() }}" name="end_at"/>
                                <button name="order" value="order book" class="btn btn-primary">Order This Book</button>
                            </form>
                        </a>
                        <a href="{{ route('books.edit', $book->getId()) }}" class="btn btn-secondary">
                            Edit
                        </a>
                        <a href="#" class="card-link">
                            <form action="{{ route('books.destroy', $book->getId()) }}" method="post">
                                @csrf
                                @method('delete')
                                <button name="order" value="order book" class="btn btn-warning">Delete</button>
                            </form>
                        </a>
                    </div>
                </div>
        @if($loop->index % 4 === 3)
            </div>
        @endif
    @endforeach
@endsection
