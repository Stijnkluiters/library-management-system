@extends('layout')

@section('content')
    <h2>Create a new book for the store</h2>

    <hr/>
    <form method="post" action="{{ route('books.store') }}">
        @include('books.form')
        <a class="btn btn-secondary" href="{{ route('books.index') }}">Back</a>
        <button type="submit" name="submit" class="btn btn-primary">Create book</button>
    </form>
@endsection
