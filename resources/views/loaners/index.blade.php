@props(['products'])
@extends('shared.layout')
@section('content')
    <script src="{{ asset('/js/button.js') }}" defer></script>
    <script src="{{ asset('/js/submitCart.js') }}" defer></script>

    @php
        $lang_file = 'loaner.index.'
    @endphp

    <x-situational.session-alert/>

    <div class="m-auto mt-3 mb-10 col-md-8 pt-3">
        <h3 class="mb-2 text-center fw-bolder">{{__($lang_file.'title')}}</h3>
        @if ($products)
            <p class="mb-3 text-center">{{__($lang_file.'products.message')}}</p>
            @foreach ($products as $product)
                @php
                    $dbProduct = \App\Models\Product::find($product['id']);
                    $image = $dbProduct->images->sortBy('priority')->first()
                @endphp
                <div class="col-10 m-auto">
                    <x-card.product.loan-card :productName="$product['name']" :productAmount="$product['amount']"
                                              :productId="$product['id']" :route="route('product_delete')"
                                              :image="$image"/>
                </div>
            @endforeach

            <form method="POST" action="{{ route('loaning_store') }}" style="display: none" id="all-products">
                @csrf
                @foreach ($products as $product)
                    <x-form.hidden-loan-card :productName="$product['name']" :productAmount="$product['amount']"
                                             :productId="$product['id']"/>
                @endforeach
            </form>

            <div class="row justify-content-center align-items-center pt-2 text-center">
                <div class="col-10 col-md-8 col-lg-6">
                    <div class="card w-100 mb-2 p-2 border-warning bg-light">
                        @php
                            $activeDueDate = \App\Models\DueDate::activeDueDate() ?? \App\Models\DueDate::defaultDueDate();
                            $date = date('d-m-Y',strtotime($activeDueDate->due_date));
                        @endphp
                        <p class="m-0">{{__($lang_file.'products.due_date.message')}}
                            op {{$date}}</p>
                    </div>
                    <button type="button" onclick="submitForm()" class="btn btn-primary w-100"
                            dusk="lening-verzenden">{{__($lang_file.'submit.button')}}</button>
                </div>
            </div>
        @else
            <div class="row justify-content-center align-items-center pt-2 text-center">
                <div class="col-12 col-sm-5">
                    <p class="mb-3 text-center"> {{__($lang_file.'products.add.message')}}</p>
                    <a class="align-items-center mb-3 text-center" href="{{ route('loaning_store') }}">
                        <button type="button"
                                class="btn btn-primary"> {{__($lang_file.'loaning.button')}}
                        </button>
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
