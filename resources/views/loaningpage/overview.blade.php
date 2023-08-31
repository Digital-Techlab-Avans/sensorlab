@extends('shared.layout')
@section('content')
    @props([
        'products',
        'categories',
        'sort_columns',
        'sort',
        'order',
    ])

    @php
        $lang_file = 'loaner.overview.';
        $secure_product_text = __($lang_file.'secure.products');
    @endphp


    <script src="{{ asset('/js/button.js') }}" defer></script>
    <script src="{{ asset('/js/submitCart.js') }}" defer></script>
    <x-situational.session-alert/>

    <div class="text-center mb-2">
        <input type="hidden" id="inputvalues" data-min="1" data-max="100">
        @php
            use App\Models\Category;
            $title = __('loaner.overview.title');
            if (request()->get('category')) {
                $title = Category::find(request()->get('category'))?->name ?? $title;
            }
        @endphp
        <x-form.search-product :categories="$categories" :sort_columns="$sort_columns" :sort="$sort" :order="$order"
                               :title="$title"/>
    </div>

    <div class="container">
        <div class="d-flex justify-content-end pe-4">
            <a type="button" class="btn d-flex align-items-center justify-content-center p-0" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                <div>{{ __('loaner.filter_and_sort.title') }}</div>
                <i class="bi bi-sliders ms-2 fs-2"></i>
            </a>
        </div>
        <x-list.product.card-view :products="$products" :secure_product_text="$secure_product_text"/>
        @if($products->count() == 0)
            <p class="text-center">{{__($lang_file.'empty_message')}}</p>
        @endif
    </div>

@endsection

