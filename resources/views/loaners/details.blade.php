@props(['loaner'])
@extends('shared.layout')
@php
    $activeLoans= $loaner->getLoansDictionary($loaner->activeLoans());
    $returns = $loaner->getReturnsDictionary($loaner->returns());
@endphp
@section('content')
    @php($lang_file = 'admin.loaner_details.')
    <x-situational.session-alert/>
    <x-layout.details-page>
        <x-slot name="title">
            {{__($lang_file.'name', ['name' => $loaner->name])}}
        </x-slot>
        <x-slot name="buttons">
            <a class="btn btn-dark" href="{{route("admin_handin", ['loaner' => $loaner])}}">{{__($lang_file.'return_products')}}</a>
            <a href="{{ route('loaners_loaning', ['id' => $loaner->id]) }}" class="btn btn-dark">{{__($lang_file.'loan_products')}}</a>
        </x-slot>
        <x-slot name="detailsTitle">{{__($lang_file.'loaner_information')}}</x-slot>
        <x-slot name="details">
            <table class="table table-striped border-dark">
                <tbody>
                <tr>
                    <th>{{__($lang_file.'email')}}</th>
                    <td>{{$loaner->email}}</td>
                </tr>
                </tbody>
            </table>
        </x-slot>

        <x-slot name="right">
            @php($loaned_products_text = __($lang_file.'loaned_products'))
            <x-sidebar.sidebar :title="$loaned_products_text" :loaner="$loaner">
                <x-slot name="first_tab_button">
                    {{__($lang_file.'loaned_tab')}}
                </x-slot>
                <x-slot name="first_tab_content">
                    @if(count($activeLoans) > 0)
                        <x-sidebar.product.loans-item :activeLoans="$activeLoans"/>
                    @else
                        <p class="text-center">{{__($lang_file.'loaned_tab_empty_message', ['name' => $loaner->name])}}</p>
                    @endif
                </x-slot>
                <x-slot name="second_tab_button">
                    {{__($lang_file.'returned_tab')}}
                </x-slot>
                <x-slot name="second_tab_content">
                    @if(count($returns) > 0)
                        <x-sidebar.product.returns-item :returns="$returns"/>
                    @else
                        <p class="text-center">{{__($lang_file.'returned_tab_empty_message', ['name' => $loaner->name])}}</p>
                    @endif
                </x-slot>
            </x-sidebar.sidebar>
        </x-slot>
    </x-layout.details-page>
@endsection
