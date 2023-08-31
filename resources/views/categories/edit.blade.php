@extends('shared.layout')
@props(['category'])
@section('content')

    <link rel="stylesheet" href="/css/product-sidebar-item.css">

    @php
        $lang_file = 'admin.category_edit.';
        $CurImagePath = $category->getImagePath() ? [$category->getImagePath()] : [];
    @endphp

    <x-layout.edit-page method="POST" formAction="/updateCategory/{{$category->id}}">
        <x-slot name="title">{{__($lang_file.'page_header')}}</x-slot>
        <x-slot name="left">
            <table class="table table-striped border-dark border">
                <tbody>
                <tr>
                    <th>{{__($lang_file.'name')}}</th>
                    <td>
                        <x-form.basic-input name="name" value="{{old('name', $category->name)}}"/>
                    </td>
                </tr>
                @php($description_label_text = __($lang_file.'description'))
                <x-interactive.table-textarea name="description" value="{{$category->description}}"
                                              :label="$description_label_text" error="description"/>
                <tr>
                    <th>{{__($lang_file.'archived')}}</th>
                    <td>
                        <x-form.checkbox name="archived" :checked="old('archived', $category->archived)"/>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="d-flex flex-row justify-content-between pb-1 pt-1">
                <div>
                    <button type="submit" class="btn btn-primary rounded"> @method('PATCH')
                        {{__($lang_file.'save')}}
                    </button>
                    <a href="/categories/details/{{$category->id}}">
                        <button class="btn btn-outline-secondary rounded mx-2" type="button">
                            {{__($lang_file.'cancel')}}
                        </button>
                    </a>
                </div>
                <div>
                    <div class="dropdown dropdown-hover">
                        <button class="btn btn-dark" type="button" id="deleteDropdown" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="deleteDropdown">
                            <li>
                                <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal{{$category->id}}" dusk="delete-button">{{__($lang_file.'delete')}}
                                </button>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="right">
            <x-interactive.carousel :editable="true" name="images" :initialImagePaths="$CurImagePath"
                                            :videos="false" :onlyOne="true"/>
        </x-slot>
    </x-layout.edit-page>

    <x-card.alerts.delete-confirmation-modal :id="$category->id" :lang_file="$lang_file" :action="'/updateCategory/'.$category->id" :isProduct="true"/>

@endsection




