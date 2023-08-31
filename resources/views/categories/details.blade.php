@props(['category', 'assignedProducts', 'unAssignedProducts'])
@extends('shared.layout')
@section('content')
    @php
        $lang_file = 'admin.category_details.';
        $CurImagePath = $category->getImagePath() ? [$category->getImagePath()] : [];
    @endphp
    <script src="{{ asset('/js/category_sidebar.js') }}" defer></script>
    <x-layout.details-page>
        <x-slot name="title">
            {{ __($lang_file . 'name', ['name' => $category->name]) }}
        </x-slot>
        <x-slot name="badges">
            @if($category->archived)
                <p class="badge bg-warning mb-1">{{__($lang_file.'archived')}}</p>
            @endif
        </x-slot>
        <x-slot name="buttons">
            <a class="btn btn-dark"
                href="{{ route('category_edit', ['category' => $category]) }}">{{ __($lang_file . 'edit') }}</a>
        </x-slot>
        <x-slot name="detailsTitle">{{ __($lang_file . 'category_information') }}</x-slot>
        <x-slot name="details">
            <table class="table table-striped border-dark">
                <tbody>
                    @php($description_text = __($lang_file . 'description'))
                    <x-interactive.table-textarea name="description" :label="$description_text" :editable="false" :value="$category->description"
                        error="description" />
                </tbody>
            </table>
        </x-slot>
        <x-slot name="detailsRight">
            <x-interactive.carousel :editable="false" name="images" :initialImagePaths="$CurImagePath" />
        </x-slot>

        <x-slot name="right">
            <x-sidebar.sidebar :title="'Producten'">
                <x-slot name="first_tab_button">
                    {{ __($lang_file . 'added_tab') }}
                </x-slot>
                <x-slot name="first_tab_content">
                    <div id="assigned">
                        @if (count($assignedProducts) > 0)
                            <div class="card sidebar-item mb-3 border border-dark">
                                <input type="text" id="product-search-input-assigned" placeholder="{{ __($lang_file . 'searchbar') }}"
                                    style=" all: unset" class="py-2">
                            </div>
                            <x-sidebar.category.assigned-items :assignedProducts="$assignedProducts" :category="$category" />
                        @else
                            <p class="text-center">{{ __($lang_file . 'added_tab_empty_message') }}</p>
                        @endif
                    </div>
                </x-slot>
                <x-slot name="second_tab_button" dusk="Niet-toegevoegd">
                    {{__($lang_file.'not_added_tab')}}

                </x-slot>
                <x-slot name="second_tab_content">
                    <div id="unassigned">
                        @if (count($unAssignedProducts) > 0)
                            <div class="card sidebar-item mb-3 border border-dark">
                                <input type="text" id="product-search-input-unassigned" placeholder="{{ __($lang_file . 'searchbar') }}"
                                    style=" all: unset" class="my-2">
                            </div>
                            <x-sidebar.category.unassigned-items :unAssignedProducts="$unAssignedProducts" :category="$category" />
                        @else
                            <p class="text-center">{{ __($lang_file . 'not_added_tab_empty_message') }}</p>
                        @endif
                    </div>
                </x-slot>
            </x-sidebar.sidebar>
        </x-slot>
    </x-layout.details-page>
@endsection
