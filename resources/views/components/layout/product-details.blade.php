@php use App\Models\ProductLink; @endphp
@props(['product', 'categories', 'lang_file', 'is_admin'])

<link href="{{ asset('css/button.css') }}" rel="stylesheet">
<script src="{{ asset('/js/button.js') }}" defer></script>
<script src="{{ asset('/js/submitCart.js') }}" defer></script>

@php
    $active_loans_dictionary = \App\Models\Product::getLoansDictionary($product->activeLoans());
    $returns_dictionary =\App\Models\Product::getReturnsDictionary($product->returns());
    $currentImagePaths = $product->images->map(fn($image) => $image->getImagePath())->toArray();
if (empty($currentImagePaths)) {
    $currentImagePaths[] = '/images/testCat.jpg';
        }
    $currentImagePriority = $product->images->mapWithKeys(fn($image) => [$image->image_name => $image->priority])->toArray();
    $currentLinkPaths = ProductLink::path_array($product);
    $currentLinkPriority = ProductLink::priority_dict($product);
@endphp

<div class="row justify-content-center m-3">
    <div class="col-12 col-md-6">
        <div class="row w-100 mb-3">
            <div class="col-1 my-auto">
                <a class="text-reset fs-2" href="{{url()->previous()}}"><i class="bi bi-arrow-left"></i></a>
            </div>
            <h1 class="text-center col m-0 me-3 text fw-bolder">{{$product->name}}</h1>
        </div>

        <div class="my-3" aria-hidden>
            <x-interactive.carousel
                :editable="false" name="images"
                :initialImagePaths="$currentImagePaths"
                :initialImagePriority="$currentImagePriority"
                :initialLinkPaths="$currentLinkPaths"
                :initialLinkPriority="$currentLinkPriority"
                :isAdmin="true"
            />
        </div>
        <div class="mb-4">
            @if ($product->is_secured)
                <p class="mt-2 grayed flex-fill text-center grayed rounded-3 fst-italic">{{__($lang_file. 'secure.products')}}</p>
            @elseif($product->no_loan_registration)
                <p class="mt-2 greyed flex-fill text-center grayed rounded-3 fst-italic">{{__('loaner.product_details.no_loan_registration.products')}}</p>
            @else
                <x-interactive.amount-input between="details-" :productId="$product->id" :disabled="$is_admin" :wideDisplay="true"/>
            @endif

        </div>
        <div>
            <p class="h4 fw-bolder">{{__($lang_file. 'product.information')}}</p>
        </div>
        <hr class="mt-2 mb-2 border-dark">
        @if(count($categories) > 0 || $product->description)
            <div class="d-flex justify-content-start flex-wrap">
                @foreach($categories as $category)
                    <a href="{{ route($is_admin ? 'category_details' : 'loaning_index', ['category' => $category->id]) }}"
                       class="btn badge text-dark btn-outline-secondary fw-bold m-1 p-2" style="border-radius: 25px;">
                        {{$category->name}}
                    </a>
                @endforeach
            </div>
            <div class="mt-2">
                @if($product->description)
                    <p class="h5 fw-bolder">{{__($lang_file. 'product.description')}}</p>
                    <p id="description"></p>
                    <x-render-markdown :markdown="$product->description" :parent_element_id="'description'"/>
                @endif
            </div>
        @else
            <div>
                <p>{{__($lang_file. 'empty.message')}}</p>
            </div>
        @endif

    </div>
</div>
