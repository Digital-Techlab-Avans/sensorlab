@php use App\Models\ProductVideo; @endphp
@props(['product'])
@extends('shared.layout')
@section('content')
    <link rel="stylesheet" href="/css/product-sidebar-item.css">

    @php
        $lang_file = 'admin.product_edit.';
        $currentImagePaths = $product->images->map(fn($image) => $image->getImagePath())->toArray();
        // create dictionary of image paths and their priority
        $currentImagePriority = $product->images->mapWithKeys(fn($image) => [$image->image_name => $image->priority])->toArray();
        $currentLinkPaths = ProductVideo::path_array($product);
        $currentLinkPriority = ProductVideo::priority_dict($product);
    @endphp

    <x-layout.edit-page formAction="/updateProduct/{{$product->id}}">
        <x-slot name="title">{{__($lang_file.'page_header')}}</x-slot>
        <x-slot name="left">
            <table class="table table-striped border-dark border">
                <tbody>
                <tr>
                    <th style="width: 40%">{{__($lang_file.'name')}}</th>
                    <td>
                        <x-form.basic-input name="name" value="{{old('name', $product->name)}}"/>
                    </td>
                </tr>
                <tr>
                    <th>{{__($lang_file.'product_code')}}</th>
                    <td>
                        <x-form.basic-input name="product_code" value="{{old('ean_code', $product->product_code)}}"/>
                    </td>
                </tr>
                <tr>
                    <th>{{__($lang_file.'stock')}}</th>
                    <td>
                        <x-form.basic-input name="stock" value="{{old('stock', $product->stock)}}"/>
                    </td>
                </tr>
                <tr>
                    <th>{{__($lang_file.'categories')}}</th>
                    <td>
                        <x-form.dropdown-chosen name="categories[]" :options="$categories" :selected="old('categories') ?? $product->categories->toArray()" :multiple="true"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="max-width: 30vw">

                <script>
  tinymce.init({
    selector: 'textarea',
    plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
  });
</script>
<textarea class="editarea" name="description" id="description" >
{{$product->description}}
</textarea>
</td>
                </tr>

                <tr>
                    <td colspan="2" style="max-width: 30vw">
                        <details {{ empty($product->description) ? '' : 'open' }}>
                            <summary class="fw-bold">{{__($lang_file.'description')}}</summary>
                            <!-- <input type="hidden" id="description" name="description"> -->
                            <!-- <x-interactive.edit-markdown linked_field="description" :markdown="old('description', $product->description)"/> -->
                        </details>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="max-width: 30vw">
                        <details {{ empty($product->notes) ? '' : 'open' }}>
                            <summary class="fw-bold">{{__($lang_file.'notes')}}</summary>
                            <input type="hidden" id="notes" name="notes">
                            <x-interactive.edit-markdown linked_field="notes" : :markdown="old('notes', $product->notes)"/>
                        </details>
                    </td>
                </tr>
                <tr>
                    <th>{{__($lang_file.'security')}}</th>
                    <td>
                        <x-form.security-input :security_level="$product->getSecurityLevel()"/>
                    </td>
                </tr>
                <tr>
                    <th>{{__($lang_file.'archived')}}</th>
                    <td>
                        <x-form.checkbox name="archived" :checked="old('archived', $product->archived)"/>
                    </td>
                </tr>
                <tr>
                    <th>{{__($lang_file.'featured')}}</th>
                    <td>
                        @php($possiblePosition = $product->featured_date ? $product->featuredPosition() : 1)
                        @php($position_text = __($lang_file.'position'))
                        <x-form.checkbox name="featured" :checked="old('featured', $product->featured_date)" label="{{$position_text}} {{ $possiblePosition}} (Wanneer aangevinkt)"/>
                    </td>
                </tr>
                </tbody>
            </table>
            <input type="hidden" id="new_categories" name="new_categories" value="">
            <input type="hidden" id="existing_categories" value="{{ json_encode($categories) }}">
            <div class="d-flex flex-row pb-1 pt-1 justify-content-between">
                <div>
                    <button type="submit" class="btn btn-primary rounded" dusk="Opslaan"> @method('PATCH')
                        {{__($lang_file.'save')}}
                    </button>
                    <a href="/products/details/{{$product->id}}">
                        <button class="btn btn-outline-secondary rounded mx-2" type="button">
                            {{__($lang_file.'cancel')}}
                        </button>
                    </a>
                </div>
                <div class="dropdown dropdown-hover">
                    <button class="btn btn-dark" type="button" id="deleteDropdown" data-bs-toggle="dropdown"
                            aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="deleteDropdown">
                        <li>
                            <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal{{$product->id}}" dusk="delete-button">{{__($lang_file.'delete')}}
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </x-slot>
        <x-slot name="right">
            <x-interactive.carousel :editable="true" name="images" :initialImagePaths="$currentImagePaths"
                                            :initialImagePriority="$currentImagePriority"
                                            :initialLinkPaths="$currentLinkPaths"
                                            :initialLinkPriority="$currentLinkPriority"
            />
        </x-slot>
    </x-layout.edit-page>

    <x-card.alerts.delete-confirmation-modal :id="$product->id" :lang_file="$lang_file" :action="'/updateProduct/'.$product->id" :isProduct="true"/>

@endsection

