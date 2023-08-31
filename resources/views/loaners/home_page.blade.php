@props(['categories', 'productRows'])
@extends('shared.layout')
@section('stylesheets')
    <link rel="stylesheet" href="/css/homepage.css">
@endsection
@section('content')

    <script src="{{ asset('/js/button.js') }}" defer></script>
    <script src="{{ asset('/js/submitCart.js') }}" defer></script>

    @php
        $lang_file = 'loaner.home_page.';
        use App\Models\User;
        $user = User::getLoggedInUser();
        $name = $user->name ?? '';
        $search_placeholder_text = __($lang_file.'search.placeholder');
        $search_description_text =  __($lang_file.'search.description');
        $secure_product_text = __($lang_file.'secure.products');
    @endphp

    <form action="{{route('loaning_index')}}" class="mb-3 text-center" method="GET">
        <x-interactive.product-search :placeholder="$search_placeholder_text"
                                      :description="$search_description_text"/>
    </form>
    <div class="container mt-3">
        <p class="text-center mt-2 mb-2 h1 fw-bolder"
           aria-hidden="true">{{__($lang_file. 'title', ['name' =>$name])}}</p>
        <div class="row text-center">
            <a class="card col bg-light border-0 m-2 p-2 text-decoration-none" href="{{route('loaning_index')}}">
                <div class="card-body p-1">
                    <i class="text-warning"><x-icons.all-products/></i>
                </div>
                <p class="fw-bold m-2">{{__($lang_file.'all_products_link')}}</p>
            </a>
            <a class="card col bg-light border-0 m-2 p-2 text-decoration-none" href="{{route('hand_in')}}">
                <div class="card-body p-1">
                    <i class="text-warning"><x-icons.hand-in/></i>
                </div>
                <p class="fw-bold m-2">{{__($lang_file.'returns_link')}}</p>
            </a>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                @foreach($productRows as $rowName => $products)
                    @if(count($products) > 0)
                        <h1 class="text-left mt-6 ps-2 h5 fw-bold">{{$rowName}}</h1>
                        <div class="product-track snaps-inline mb-4" data-mouse-down-at="0" data-prev-percentage="0">
                            @foreach ($products as $product)
                                <x-card.product.card :product="$product" :secure_product_text="$secure_product_text"/>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="container mt-3">
        <h1 class="text-left mt-6 ps-2 h5 fw-bold">{{__($lang_file.'category.title')}}</h1>
        <div class="row row-cols-2 g-3 mb-3">
            @foreach ($categories as $category)
                <div class="card category-card-main rounded-4 shadow-sm ms-4 mt-4 border-primary-subtle" title="{{ $category->description }}">
                    <a href="{{ route('loaning_index', ['category' => $category->id]) }}" class="text-decoration-none">
                        <div class="category-card-media d-flex justify-content-center" aria-hidden="true">
                            @if ($category->getImagePath())
                                <img src="{{ $category->getImagePath() }}" alt="{{ $category->name }} category image" draggable="false">
                            @endif
                        </div>
                        <div class="text-center">
                            <p class="card-title h6 fw-bold text-dark">{{ $category->name }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
