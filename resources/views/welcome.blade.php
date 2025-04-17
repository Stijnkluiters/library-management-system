@extends('layout')

@section('content')
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">Library Management System</h1>
                <p class="lead text-body-secondary">Domain Driven Design example where customers can rent a book.
                    By Stijn Kluiters
                </p>
            </div>
        </div>
    </section>

    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                @forelse($products as $product)
                    <div class="col">
                        <div class="card shadow-sm">
                            <img class="img img-thumbnail w-75 mx-auto"
                                 src="{{ '/images/'.$product->getImage() }}"
                                 alt="{{ $product->getName() }}"
                                 style="max-height: 200px;"
                            />
                            <div class="card-body">
                                <p class="card-text">{{ $product->getName() }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a type="submit"
                                                href="{{ route('home.addToCart', $product->getUuid()) }}"
                                                class="btn btn-sm btn-outline-secondary">
                                            Add To Cart
                                        </a>
                                    </div>
                                    <small class="text-body-secondary">Per Day: &euro;{{ $product->getPrice()->toHumanReadableString() }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>
                        No products are currently sold, perhaps you could run the seeder?
                        `php artisan db:seed`
                    </p>
                @endforelse

            </div>
        </div>
    </div>
@endsection
