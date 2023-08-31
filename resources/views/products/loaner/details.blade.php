@php use App\Models\ProductLink; @endphp
@props(['product', 'categories'])
@extends('shared.layout')
@section('content')
    <x-layout.product-details :product="$product" :categories="$categories" :lang_file="'loaner.product_details.'" :is_admin="false" />
@endsection



