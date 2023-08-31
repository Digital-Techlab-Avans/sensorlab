@props(['unAssignedProducts', 'category'])
@php
    $isAssigned = false;
@endphp
@foreach ($unAssignedProducts as $product)
    <x-sidebar.category.item :name="$product->name" route="{{ route('product_details', $product->id) }}" :isAssigned="$isAssigned"
        :productId="$product->id" :category="$category" />
@endforeach
