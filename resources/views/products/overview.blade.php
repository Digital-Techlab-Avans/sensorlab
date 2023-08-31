@extends('shared.layout')
@php
    $lang_file = 'admin.products_overview.';
    $products_table_text = __($lang_file . 'page_header');

    $all_products_tab = __($lang_file . 'all_products_tab');
    $active_products_tab = __($lang_file . 'active_products_tab');
    $archived_products_tab = __($lang_file . 'archived_products_tab');
    $locked_products_tab = __($lang_file . 'locked_products_tab');
    $no_registration_products_tab = __($lang_file . 'no_registration_products_tab');
    $tabs = [$all_products_tab, $active_products_tab, $archived_products_tab, $locked_products_tab, $no_registration_products_tab];
@endphp
@section('content')
    <script src="{{asset('js/nav_tabs.js')}}" defer></script>
    <x-layout.page-top :title="$products_table_text">
        <a href="{{ route('product_create') }}">
            <div class="btn text-light bg-primary">{{ __($lang_file . 'create') }}</div>
        </a>
    </x-layout.page-top>

    <x-layout.switchable-tabs :tabs="$tabs">
        <x-slot name="slot_0">
            <x-table.products.layout :lang_file="$lang_file" :products="$products">
            </x-table.products.layout>
        </x-slot>
        <x-slot name="slot_1">
            <x-table.products.layout :lang_file="$lang_file" :products="$active_products">
            </x-table.products.layout>
        </x-slot>
        <x-slot name="slot_2">
            <x-table.products.layout :lang_file="$lang_file" :products="$archived_products">
            </x-table.products.layout>
        </x-slot>
        <x-slot name="slot_3">
            <x-table.products.layout :lang_file="$lang_file" :products="$secured_products">
            </x-table.products.layout>
        </x-slot>
        <x-slot name="slot_4">
            <x-table.products.layout :lang_file="$lang_file" :products="$no_registration_products">
            </x-table.products.layout>
        </x-slot>
    </x-layout.switchable-tabs>

    <script>
        const ARCHIVE_COLUMN_INDEX = 2;
        const DETAIL_COLUMN_INDEX = 9;

        dataTableConfig.orderCellsTop = true;
        dataTableConfig.order = [
            [1, 'asc']
        ];
        dataTableConfig.columns = [{
                // Hide the ID column
                visible: false,
            },
            {},
            {
                // Prevent sorting the archived column (it's a checkbox)
                sortable: false,
            },
            {},
            {
                sortable: false,
            },
            {},
            {
                sortable: false,
            },
            {},
            {
                // Prevent sorting the featured column (it's a checkbox)
                sortable: true,
            },
            {
                sortable: false,
                searchable: false,
            }
        ];
        dataTableConfig.initComplete = function() {
            globalThis.table = this;
            $('#show-archived').click();
        };

        let tables = $('.lend_products_table');
        tables.each(function() {
            new DataTable(this, dataTableConfig);
        });
    </script>
@endsection
