@extends('shared.layout')
@section('content')
    @php
        $lang_file = 'admin.product_create.';
        $route = route("product_create");
    @endphp

    <x-layout.edit-page formAction="{{$route}}">
        <x-slot name="title">{{__($lang_file.'page_header')}}</x-slot>
        <x-slot name="left">
            <table class="table border-dark border">
                <tbody>
                <tr>
                    <th style="width: 40%">{{__($lang_file.'name')}}</th>
                    <td>
                        <x-form.basic-input name="name" value="{{old('name')}}"/>
                    </td>
                </tr>
                <tr>
                    <th>{{__($lang_file.'product_code')}}</th>
                    <td>
                        <x-form.basic-input name="product_code" value="{{old('product_code')}}"/>
                    </td>
                </tr>
                <tr>
                    <th>{{__($lang_file.'stock')}}</th>
                    <td>
                        <x-form.basic-input name="stock" value="{{old('stock')}}"/>
                    </td>
                </tr>
                <tr>
                    <th>{{__($lang_file.'categories')}}</th>
                    <td>
                        <x-form.dropdown-chosen name="categories[]" :options="$categories"
                                                :selected="old('categories') ?? []" :multiple="true"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="max-width: 30vw">
                        <details open>
                            <summary class="fw-bold">{{__($lang_file.'description')}}</summary>
                            <input type="hidden" id="description" name="description">
                            <x-interactive.edit-markdown linked_field="description" :markdown="''"/>
                        </details>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="max-width: 30vw">
                        <details>
                            <summary class="fw-bold">{{__($lang_file.'notes')}}</summary>
                            <input type="hidden" id="notes" name="notes">
                            <x-interactive.edit-markdown linked_field="notes" : :markdown="''"/>
                        </details>
                    </td>
                </tr>
                <tr>
                    <th>{{__($lang_file.'security')}}</th>
                    <td>
                        <x-form.security-input :security_level="'normal'"/>
                    </td>
                </tr>
                <tr>
                    <th>{{__($lang_file.'archived')}}</th>
                    <td>
                        <x-form.checkbox name="archived" :checked="old('archived', false)"/>
                    </td>
                </tr>
                <tr>
                    <th>{{__($lang_file.'featured')}}</th>
                    <td>
                        @php($featured_position_text = __($lang_file.'position'))
                        <x-form.checkbox name="featured" :checked="old('featured', false)"
                                         :label="$featured_position_text.' 1 (Wanneer aangevinkt)'"/>
                    </td>
                </tr>
                </tbody>
            </table>
            <input type="hidden" id="new_categories" name="new_categories" value="">
            <input type="hidden" id="existing_categories" value="{{ json_encode($categories) }}">
            <button type="submit" class="btn btn-primary rounded" dusk="Aanmaken">{{__($lang_file.'create')}}</button>
        </x-slot>
        <x-slot name="right">
            <x-interactive.carousel :editable="true" name="images"/>
        </x-slot>
    </x-layout.edit-page>
@endsection
