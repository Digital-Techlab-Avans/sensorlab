@props(['loaner'])
@extends('shared.layout')
@section('content')

    <script src="{{ asset('/js/button.js') }}"></script>

    <link rel="stylesheet" href="/css/sidebar.css">

    @php
        $lang_file = 'loaner.hand_in.'
    @endphp


    <x-situational.session-alert/>

    <div class="row w-100">
        <div class="mt-3 mb-10 col-12 m-auto">
            <h3 class="mb-3 pt-3 fw-bolder text-center">{{__($lang_file.'title')}}</h3>
            <p class="text-center mt-0 mb-3 m-5">{{__($lang_file.'extra_title_information')}}</p>

            @php
                $activeLoans = $loaner->getLoansDictionary($loaner->activeLoans());
                $activeLoans = collect($activeLoans)->sortKeysDesc();
            @endphp

            @if(count($activeLoans) > 0)
                <form action="{{ route('hand_in') }}" method="POST">
                    @csrf
                    <div class="col-10 col-md-8 col-lg-6 m-auto">
                        @foreach($activeLoans as $productId => $loanArray)
                            @php
                                $image = $loanArray[0]->product->images->sortBy('priority')->first();
                                $productAmount = 0;
                                foreach ($loanArray as $loan) {
                                    $productAmount += $loan->remainingAmount();
                                }
                            @endphp
                            <x-card.product.handin-card :loanArray="$loanArray" :productAmount="$productAmount"
                                                        :productId="$productId" :image="$image"/>

                            <input type="hidden" id="productId" value="{{ $productId }}">
                            <input type="hidden" id="productAmount" value="{{ $productAmount }}">

                        @endforeach
                    </div>
                    <script src="{{ asset('/js/invalid.js') }}"></script>

                    <div class="row justify-content-center align-items-center pt-3 text-center">
                        <div class="col-10 col-sm-8 col-md-6">
                            <button type="submit"
                                    class="btn btn-primary hand-in-submit fw-bold w-100"
                                    dusk="bevestig-inlevering">{{__($lang_file.'submit.button')}}</button>
                        </div>
                    </div>
                </form>
            @else
                <p class="text-center">{{__($lang_file.'empty_message')}}</p>
            @endif

        </div>
    </div>

@endsection
