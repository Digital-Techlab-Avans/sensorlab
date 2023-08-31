@props(['loaner'])
@extends('shared.layout')
@section('content')

    <script src="{{ asset('/js/button.js') }}"></script>

    <link rel="stylesheet" href="/css/sidebar.css">

    <x-situational.session-alert/>

    <div class="container mt-3 mb-10 col-md-6">
        <h1 class="mb-4 text-center">Product(en) inleveren voor {{$loaner->name}}</h1>

        @php
            $activeLoans = collect($loaner->getLoansDictionary($loaner->activeLoans()))->sortKeysDesc();
        @endphp

        @if(count($activeLoans) > 0)
            <form action="{{ route('admin_handin', ['loaner' => $loaner])}}" method="POST">
                @csrf
                @foreach($activeLoans as $productId => $loanArray)
                    @php
                        $productAmount = 0;
                        foreach ($loanArray as $loan) {
                            $productAmount += $loan->remainingAmount();
                        }
                    @endphp

                    <x-card.product.handin-card :loanArray="$loanArray" :productAmount="$productAmount"
                                                :productId="$productId"/>

                    <input type="hidden" id="productId" value="{{ $productId }}">
                    <input type="hidden" id="productAmount" value="{{ $productAmount }}">

                @endforeach
                <script src="{{ asset('/js/invalid.js') }}"></script>

                <div class=" text-center mt-4">
                    <a href="{{route("loaners_details", ['id' => $loaner->id])}}"
                       class="btn btn-outline-dark me-3">Annuleer inlevering</a>

                    <button type="submit" class="btn btn-dark hand-in-submit" dusk="bevestig-inlevering">Bevestig inlevering</button>
                </div>
                @else
                    <div class="row justify-content-center align-items-center pt-4 text-center">
                        <div class="col-12 col-sm-5">
                            <p class="h3 mb-3 mt-3 text-center ">Je hebt op dit moment geen producten
                                geleend.</p>
                            <a href="{{ route('loaners_details', ['id' => $loaner->id]) }}"
                               class="btn btn-outline-dark me-3">Annuleer inlevering</a>
                        </div>
                    </div>

        @endif

    </div>

@endsection
