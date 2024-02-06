@extends('layout')

@section('content')
    <h2>Edit the book</h2>

    <hr/>
    <form method="post" action="{{ route('books.update', $book->getId()) }}">
        {{ method_field('patch') }}
        @include('books.form')
        <a class="btn btn-secondary" href="{{ route('books.index') }}">Back</a>
        <button type="submit" name="submit" class="btn btn-primary">Edit book</button>
    </form>
@endsection
