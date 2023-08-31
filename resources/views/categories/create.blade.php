@extends('shared.layout')
@section('content')
    @php
        $lang_file = 'admin.category_create.';
        $route = route("category_create");
    @endphp

    <x-layout.edit-page formAction="{{$route}}">
        <x-slot name="title">{{__($lang_file.'page_header')}}</x-slot>
        <x-slot name="left">
            <table class="table table-striped border-dark border">
                <tbody>
                <tr>
                    <th>{{__($lang_file.'name')}}</th>
                    <td>
                        <x-form.basic-input name="name" value="{{old('name')}}"/>
                    </td>
                </tr>
                @php($description_label_text = __($lang_file.'description'))
                <x-interactive.table-textarea name="description" :label="$description_label_text" error="description"/>
                <tr>
                    <th>{{__($lang_file.'archived')}}</th>
                    <td>
                        <x-form.checkbox name="archived" :checked="old('archived', false)"/>
                    </td>
                </tr>
            </table>
            <button type="submit" class="btn btn-primary rounded">{{__($lang_file.'create')}}</button>
        </x-slot>
        <x-slot name="right">
            <x-interactive.carousel :editable="true" name="images" :videos="false" :onlyOne="true"/>
        </x-slot>
    </x-layout.edit-page>
@endsection
