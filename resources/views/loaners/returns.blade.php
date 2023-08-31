@props(['returns', 'pendingReturns' => [], 'acceptedReturns' => [], 'declinedReturns' => []])
@extends('shared.layout')
@section('content')

    @php
        $lang_file = 'loaner.returns.';

        $tabs = [
            __($lang_file.'all.returns.tab.title'),
            __($lang_file.'pending.returns.tab.title'),
            __($lang_file.'accepted.returns.tab.title'),
            __($lang_file.'denied.returns.tab.title')
        ];
    @endphp

    <div>
        <h3 class="mb-3 pt-3 fw-bolder text-center">{{__($lang_file.'title')}}</h3>
        <div class="m-2">
            <x-layout.switchable-tabs :tabs="$tabs">
                <x-slot name="slot_0">
                    <div class="container">
                        @if($returns->isEmpty())
                            <p class="text-center mt-2">{{__($lang_file.'empty.message')}}</p>
                        @endif
                        @foreach($returns as $return)
                            <x-card.returns.return-card :returnItem="$return"/>
                        @endforeach
                    </div>
                </x-slot>
                <x-slot name="slot_1">
                    <div class="container">
                        @if($pendingReturns->isEmpty())
                            <p class="text-center mt-2">{{__($lang_file.'pending.returns.empty.message')}}</p>
                        @endif
                        @foreach($pendingReturns as $return)
                            <x-card.returns.return-card :returnItem="$return" :showStatusText="false"/>
                        @endforeach
                    </div>
                </x-slot>
                <x-slot name="slot_2">
                    <div class="container">
                        @if($acceptedReturns->isEmpty())
                            <p class="text-center mt-2">{{__($lang_file.'accepted.returns.empty.message')}}</p>
                        @endif
                        @foreach($acceptedReturns as $return)
                            <x-card.returns.return-card :returnItem="$return" :showStatusText="false"/>
                        @endforeach
                    </div>
                </x-slot>
                <x-slot name="slot_3">
                    <div class="container">
                        @if($declinedReturns->isEmpty())
                            <p class="text-center mt-2">{{__($lang_file.'denied.returns.empty.message')}}</p>
                        @endif
                        @foreach($declinedReturns as $return)
                            <x-card.returns.return-card :returnItem="$return" :showStatusText="false"/>
                        @endforeach
                    </div>
                </x-slot>
            </x-layout.switchable-tabs>
        </div>
    </div>
@endsection
