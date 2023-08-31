@props(['product', 'secure_product_text'])
@php
    $productId = $product->id;
    $productName = $product->name;
@endphp

<link href="{{ asset('css/button.css') }}" rel="stylesheet">

<div class="card h-100 d-flex align-content-between rounded-4 border-primary-subtle">
    <a href="{{ route('product_loaner_details', ['product' => $productId]) }}" aria-hidden="true" class="h-100" style="overflow: hidden;">
        <div class="h-100 d-flex justify-content-center align-items-center m-2 rounded-1">
            @if (isset($product->images) && $product->images->count() > 0)
                <img src="{{ $product->images->sortBy('priority')->first()->getImagePath() }}"
                     alt="{{ $productName }}"
                     class="h-100 w-100 product-card" style="object-fit: contain; max-height: 200px" draggable="false">
            @else
                <img src="{{ asset('/images/testCat.jpg') }}" alt="{{ $productName }}" class="h-100 w-100 product-card"
                     style="object-fit: contain" draggable="false">
            @endif
        </div>
    </a>
    <div class="card-body p-0 text-center">
        <p class="h6 fw-bold {{ $product->is_secured ? 'm-0' : 'm-2' }}">{{ $productName }} @if ($product->is_secured)
             <x-icons.lock-icon />
        @endif</p>
        @if ($product->is_secured)
            <p class="m-0 fst-italic text-primary border-top">{{$secure_product_text}}</p>
        @elseif($product->no_loan_registration)
            <p class="m-0 fst-italic text-primary border-top">{{__('loaner.overview.no_loan_registration.products')}}</p>
        @else
            <x-interactive.amount-input between="card-" :productId="$productId"/>
        @endif
    </div>
</div>
