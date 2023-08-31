@props(['products', 'secure_product_text'])
@php
    $totalAmountOfProducts = count($products);
    $lang_file = 'loaner.overview.';
@endphp
<script src="{{ asset('/js/show-more-card-view.js') }}" defer></script>
<div class="container" id="cardView">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4">
            @foreach ($products as $product)
                <div class="col mb-4">
                    <x-card.product.card :product="$product" :secure_product_text="$secure_product_text" />
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .btn-outline-dark {
        background-color: white;
    }
</style>
<div class="container d-flex justify-content-center text-center">
    <div>
        <p class="text-secondary" id="shownItems"></p>
        <button id="loadMoreButton" class="btn btn-primary">{{ __($lang_file . 'show_more') }}</button>
    </div>
</div>
