@php use App\Models\ProductVideo; @endphp
@props(['product'])
@extends('shared.layout')
@section('content')
    @php
        $lang_file = 'admin.product_details.';
        $active_loans_dictionary = \App\Models\Product::getLoansDictionary($product->activeLoans());
        $returns_dictionary =\App\Models\Product::getReturnsDictionary($product->returns());
        $currentImagePaths = $product->images->map(fn($image) => $image->getImagePath())->toArray();
        $currentImagePriority = $product->images->mapWithKeys(fn($image) => [$image->image_name => $image->priority])->toArray();
        $currentLinkPaths = ProductVideo::path_array($product);
        $currentLinkPriority = ProductVideo::priority_dict($product);
    @endphp
    <x-situational.session-alert/>
    <x-layout.details-page>
        <x-slot name="title">
            {{__($lang_file.'name', ['name' => $product->name])}}
        </x-slot>
        <x-slot name="badges">
            @if($product->is_secured)
                <p class="badge bg-danger mb-1">{{__($lang_file.'secured')}}</p>
            @elseif($product->no_loan_registration)
                <p class="badge bg-info mb-1">{{__($lang_file.'no_loan_registration')}}</p>
            @endif
            @if($product->archived)
                <p class="badge bg-warning mb-1">{{__($lang_file.'archived')}}</p>
            @elseif($product->featured_date)
                @php($featuredPostion = $product->featuredPosition())
                <p class="badge bg-success mb-1 text-wrap">{{__($lang_file.'featured')}} ({{__($lang_file.'position')}} {{$featuredPostion}})</p>
            @endif
        </x-slot>
        <x-slot name="buttons">
            <a class="btn btn-dark"
               href="{{route("product_preview", ['product' => $product])}}">{{__($lang_file.'preview')}}</a>
            <a class="btn btn-dark"
               href="{{route("product_edit", ['product' => $product])}}">{{__($lang_file.'edit')}}</a>
        </x-slot>
        <x-slot name="detailsTitle">{{__($lang_file.'product_information')}}</x-slot>
        <x-slot name="details">
            <table class="table table-striped border-dark" role="presentation">
                <tbody>
                <tr>
                    <th style="width: 30%" scope="row">{{__($lang_file.'product_code')}}</th>
                    <td tabindex="0">
                        <span style="font-family: monospace" class="badge bg-dark">{{$product->product_code}}</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">{{__($lang_file.'stock')}}</th>
                    <td tabindex="0">{{$product->stock ?? "Onbekend"}}</td>
                </tr>
                <tr>
                    <th scope="row">{{__($lang_file.'categories')}}</th>
                    <td tabindex="0">
                        @if(count($product->categories) > 0)
                            @foreach($product->categories as $category)
                                @if(isset($category->archived))
                                <a href="/categories/details/{{$category->id}}"
                                   class="badge bg-secondary text-decoration-none fst-italic">{{$category->name}}</a>
                                @else
                                <a href="/categories/details/{{$category->id}}"
                                   class="badge bg-dark text-decoration-none">{{$category->name}}</a>
                                @endif
                            @endforeach
                        @else
                            <span>{{__($lang_file.'categories_empty')}}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    @if ($product->description)
                        @php($description_lines = count(explode("\n", $product->description)))
                        @php($description_form = $description_lines == 1 ? 'singular' : 'plural')
                        <td colspan="2">
                            <details>
                                <summary>
                                    <span class="fw-bold">{{__($lang_file.'description')}}</span>
                                    <span>{{__($lang_file."about_text_$description_form", ['lines' => $description_lines, 'characters' => strlen($product->description)])}}</span>
                                </summary>
                                <p id="description"></p>
                                <x-render-markdown :markdown="$product->description" parent_element_id="description"/>
                            </details>
                        </td>
                    @else
                        <th>{{__($lang_file.'description')}}</th>
                        <td>{{__($lang_file.'no_description')}}</td>
                    @endif
                </tr>
                <tr>
                    @if ($product->notes)
                        @php($notes_lines = count(explode("\n", $product->notes)))
                        @php($notes_form = $notes_lines == 1 ? 'singular' : 'plural')
                        <td colspan="2">
                            <details>
                                <summary>
                                    <span class="fw-bold">{{__($lang_file.'notes')}}</span>
                                    <span>{{__($lang_file."about_text_$notes_form", ['lines' => $notes_lines, 'characters' => strlen($product->notes)])}}</span>
                                </summary>
                                <p id="notes"></p>
                                <x-render-markdown :markdown="$product->notes" parent_element_id="notes"/>
                            </details>
                        </td>
                    @else
                        <th>{{__($lang_file.'notes')}}</th>
                        <td>{{__($lang_file.'no_notes')}}</td>
                    @endif
                </tr>
                </tbody>
            </table>

        </x-slot>
        <x-slot name="detailsRight">
            <x-interactive.carousel
                :editable="false" name="images"
                :initialImagePaths="$currentImagePaths"
                :initialImagePriority="$currentImagePriority"
                :initialLinkPaths="$currentLinkPaths"
                :initialLinkPriority="$currentLinkPriority"
            />
        </x-slot>
        <x-slot name="detailsBottom">
            <details>
                <summary class="fs-3">{{__($lang_file.'timeline')}}</summary>
                <x-list.product.timeline :ledger="$ledger"/>
            </details>
        </x-slot>

        <x-slot name="right">
            @php($product_loans_text = __($lang_file.'product_loans'))
            <x-sidebar.sidebar :title="$product_loans_text">
                <x-slot name="first_tab_button">
                    {{__($lang_file.'loaned_tab')}}
                </x-slot>
                <x-slot name="first_tab_content">
                    <x-list.product.loans :active_loans_dictionary="$active_loans_dictionary"/>
                </x-slot>
                <x-slot name="second_tab_button">
                    {{__($lang_file.'returned_tab')}}
                </x-slot>
                <x-slot name="second_tab_content">
                    <x-list.product.returns :returns_dictionary="$returns_dictionary"/>
                </x-slot>
            </x-sidebar.sidebar>
        </x-slot>
    </x-layout.details-page>

@endsection
