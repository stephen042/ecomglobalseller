@extends('layouts.users')

@section('content')
<div class="m-3">
    <button class="btn btn-primary mb-2" onclick="window.location.href='{{ route('dashboard')}}'">
        <i class="bi bi-house"></i>
        Back
    </button>
    <x-error-message />
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                @forelse ($catalogs as $catalog)
                <div class="card">
                    <div class="card-body m-0 p-0">
                        <div class="row m-3">
                            <!-- Image section -->
                            <div class="col-12 col-md-4 order-1 order-md-1 m-0">
                                <div id="productCarousel{{ $catalog->id }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @php
                                        $products = json_decode($catalog->photos,true);
                                        @endphp
                                        {{-- @dd($products) --}}
                                        @foreach($products as $index => $product)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $product) }}" class="d-block w-100"
                                                alt="Product Image" height="300">
                                        </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#productCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#productCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                            <!-- Text section -->
                            <div class="col-12 col-md-8 order-2 order-md-2 m-0">
                                <h3>{{$catalog->productName}}</h3>
                                <hr>
                                <div>
                                    Price -: <span><b>${{$catalog->price}}</b></span>
                                </div>
                                <hr>
                                <p>
                                    <h3>Description</h3>
                                    {{$catalog->productDescription}}
                                </p>
                                <span>
                                    <p class="m-0 text-dark">Quantity : {{$catalog->productQuantity}}</p>
                                    <p class="m-0">{{ date('Y/M/d h:i', strtotime($catalog->created_at)) }}</p>
                                    <p>By <span class="text-info"><i>{{auth()->user()->name}}- (Author)</i></span></p>
                                </span>
                                <div>
                                    @if ($catalog->soldInStock == '1')
                                    <span class="badge bg-info">In stock</span>
                                    @else
                                    <span class="badge bg-danger">Sold Out</span>
                                    @endif
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- Pagination links -->
                </div>
                @empty
                <h1>No uploaded products yet</h1>
                @endforelse

                <div>
                    {{ $catalogs->links() }}
                </div>
            </div>
        </div>
    </section>

</div>
@endsection