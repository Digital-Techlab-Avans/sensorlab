@extends('shared.layout')
@php
// dd($loaners, $active_loaners, $inactive_loaners);
    $lang_file = 'admin.loaners_overview.';
    $page_title = __('admin.loaners_overview.page_header');
    
    $all_loaners_tab = __($lang_file . 'all_loaners_tab');
    $active_loaners_tab = __($lang_file . 'active_loaners_tab');
    $archived_loaners_tab = __($lang_file . 'archived_loaners_tab');
    $tabs = [$all_loaners_tab, $active_loaners_tab, $archived_loaners_tab];
@endphp
@section('content')
    <script src="{{ asset('js/nav_tabs.js') }}" defer></script>
    <x-layout.page-top :title="$page_title">
        <a href="{{ route('loaners_create') }}">
            <div class="btn text-light bg-primary">{{ __($lang_file . 'create') }}</div>
        </a>
    </x-layout.page-top>

    <x-layout.switchable-tabs :tabs="$tabs" :startPage="1">
        <x-slot name="slot_0">
            <x-table.loaners.layout :lang_file="$lang_file" :loaners="$loaners">
            </x-table.loaners.layout>
        </x-slot>
        <x-slot name="slot_1">
            <x-table.loaners.layout :lang_file="$lang_file" :loaners="$active_loaners">
            </x-table.loaners.layout>
        </x-slot>
        <x-slot name="slot_2">
            <x-table.loaners.layout :lang_file="$lang_file" :loaners="$inactive_loaners">
            </x-table.loaners.layout>
        </x-slot>
    </x-layout.switchable-tabs>

    <script>
        const ARCHIVE_COLUMN_INDEX = 1;
        const LATE_RETURNED_COLUMN_INDEX = 5;

        dataTableConfig.orderCellsTop = true;
        dataTableConfig.order = [
            [LATE_RETURNED_COLUMN_INDEX, 'desc']
        ];
        dataTableConfig.columns = [{
                // Hide the ID column
                visible: false,
            },
            {
                // Hide the archived column
                visible: false,
            },
            {
                // Name column
            },
            {
                // Email column
            },
            {
                // Currently loaned column
            },
            {
                // Late returned column
            },
            {
                // Details button column
                orderable: false,
            },
        ];
        dataTableConfig.initComplete = function() {
            globalThis.table = this;
        };

        let tables = $('.loaner_table');
        tables.each(function() {
            new DataTable(this, dataTableConfig);
        });
    </script>
@endsection
