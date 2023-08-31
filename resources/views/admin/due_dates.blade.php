@props(['futureDueDates', 'pastDueDates'])
@extends('shared.layout')
@section('content')
    @php
        $lang_file = 'admin.due_dates.';
        $due_dates_text = __($lang_file.'page_header');

        $future_tab = __($lang_file.'future_tab');
        $future_tab_empty_message = __($lang_file.'future_tab_empty_message');
        $past_tab = __($lang_file.'past_tab');
        $past_tab_empty_message = __($lang_file.'past_tab_empty_message');
        $tabs = [$future_tab, $past_tab];
    @endphp
    <script src="{{asset('js/due_dates.js')}}"></script>

    <x-situational.session-alert :success="'success'"/>

    <x-layout.page-top :title="$due_dates_text"></x-layout.page-top>
    <form action="{{route('due_dates_create')}}" method="POST" id="new_due_date_form" class="mb-4">
        @csrf
        <div class="row w-100 justify-content-center text-center mt-3" style="position: relative">
            <div class="card" style="width: min(30em, 80vw)">
                <label class="card-text m-2" for="datetime">{{__($lang_file.'new_due_date')}}</label>
                <div class="row card-body">
                    <div class="col-12 mb-2 flex-sm-grow-1 col-sm-auto mb-sm-0 p-0">
                        @php($new_due_date_placeholder_text = __($lang_file.'new_due_date_placeholder'))
                        <x-interactive.datetimepicker-flatpickr :placeholder="$new_due_date_placeholder_text" :value="date('d-m-Y H:i')"/>
                    </div>
                    <div class="col flex-sm-grow-0 p-0">
                        <button type="submit" id="due_date_submit_button" disabled class="btn btn-primary">
                            {{__($lang_file.'add')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <x-layout.switchable-tabs :tabs="$tabs">
        <x-slot name="slot_0">
            <div class="col-md-8 col-xl-6 m-2 mx-auto">
                <x-list.due-date.list-view :due_dates="$futureDueDates"
                                           :empty_message="$future_tab_empty_message" :lang_file="$lang_file"/>
            </div>
        </x-slot>
        <x-slot name="slot_1">
            <div class="col-md-8 col-xl-6 m-2 mx-auto">
                <x-list.due-date.list-view :due_dates="$pastDueDates"
                                           :empty_message="$past_tab_empty_message" :lang_file="$lang_file"/>
            </div>
        </x-slot>
    </x-layout.switchable-tabs>
@endsection
