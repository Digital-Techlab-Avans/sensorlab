@extends('shared.layout')
@section('content')
    @php
        $lang_file = 'admin.loaner_create.';
        $page_title = __($lang_file.'page_header');
    @endphp
    <x-layout.edit-page
        :title="$page_title"
        method="POST"
        formAction="{{ route('loaners_create') }}"
    >
        <x-slot name="left">
            <table class="table table-striped border-dark border">
                <tbody>
                <tr>
                    <th style="width: 20%">{{__($lang_file.'name')}}</th>
                    <td>
                        <x-form.basic-input name="name" value="{{old('name')}}"/>
                    </td>
                </tr>
                <tr>
                    <th>{{__($lang_file.'email')}}</th>
                    <td>
                        <x-form.basic-input name="email" value="{{old('email')}}" type="email"/>
                    </td>
                </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary rounded">{{__($lang_file.'create')}}</button>
        </x-slot>
    </x-layout.edit-page>
@endsection
