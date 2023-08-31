@props([
    'name', 'editable' => false,
    'images' => true,
    'videos' => true,
    'onlyOne' => false,
    'initialImagePaths' => '',
    'initialImagePriority' => '',
    'carouselIntervalMs' => 0,
    'initialLinkPaths' => [],
    'initialLinkPriority' => [],
    'isAdmin' => false
])

{{--IMPORTANT: ADD enctype="multipart/form-data" TO FORM--}}

<x-situational.error-message :error="$name"/>

<link rel="stylesheet" href="/css/carousel.css">
@if($editable)
    <div class="text-center">
        @if($onlyOne)
            <i>{{__('admin.content_carousel.chose_one')}}</i>
        @else
            <i>{{__('admin.content_carousel.chose_multiple')}}</i>
        @endif
    </div>
@endif

@if($isAdmin)
    <div class="card carousel-card mb-3">
        @endif

        <div id="carousel-control" class="carousel slide carousel-dark" data-bs-ride="carousel"
             data-bs-interval="{{$carouselIntervalMs}}">
            <div class="row justify-content-center">
                <div class="row {{$isAdmin ? 'w-90' : 'w-75'}}">
                    <div class="carousel-inner {{$isAdmin ? 'text-center mt-1' : ''}}" id="image-carousel-container" style="height: 40vh;">
                        <!-- Initial images will be added here -->
                    </div>
                    <button id="carousel-previous-button" class="carousel-control-prev" type="button"
                            data-bs-target="#carousel-control" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button id="carousel-next-button" class="carousel-control-next" type="button"
                            data-bs-target="#carousel-control" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <div class="{{$isAdmin ? 'mt-5' : 'mt-4'}}">
                    <div id="carousel-indicators-container" class="carousel-indicators m-0"></div>
                </div>
            </div>
        </div>

        @if($isAdmin)
    </div>

    <div class="carousel-thumbnails text-center d-flex flex-row flex-wrap justify-content-center gap-3 row-gap-0">
        <div class="card thumbnail-card">
            <!-- Miniatuurafbeeldingen worden hier toegevoegd -->
        </div>
    </div>
@endif



<div id="file-name-explanation" class="row text-center" {{$editable? '': 'hidden'}}>
    <i>{{__('admin.content_carousel.determine_media_order')}}</i>
</div>
<ul id="carousel-label-list" class="drag-sort-enable p-2" {{$editable? '': 'hidden'}}>
    <!-- Initial image file names will be added here -->
</ul>

<input id="image-file-priority" type="hidden" name="{{$name}}_priority" value="">
<input id="youtube-video-priority" type="hidden" name="youtube_priority" value="">
<div id="content-filetype-error" hidden="true">
    <p class="text-danger m-0">
        {{__('admin.content_carousel.file_error')}}
    </p>
</div>
@if($images)
    <div class="mb-3" {{$editable? '': 'hidden'}}>
        <div class="input-group">
            <input id="image-input" accept="image/png, image/jpg, image/jpeg, image/webm, image/webp, image/gif" type="file" name="{{$name}}[]"
                   {{!$onlyOne ? 'multiple' : ''}} class="form-control">
            <button id="upload-images-button" type="button" class="btn btn-dark rounded-end" style="width: 100px">{{__('admin.content_carousel.upload')}}</button>
        </div>
        <span class="text-muted">
            {{__('admin.content_carousel.file_info')}}
        </span>
@endif
@if($editable)
    <div class="row justify-content-center">
        @if($videos)
            <div class="input-group mb-3">
                <input id="link-input" type="text" name="link" class="form-control" placeholder="Media link">
                <button id="add-media-link-button" type="button" class="btn btn-dark" style="width: 100px;">{{__('admin.content_carousel.add')}}</button>
            </div>
        @endif
    </div>
@endif

@if ($errors->has('images.*'))
    <div class="alert alert-danger">
        {{ __('admin.content_carousel.image_upload_failed') }}
    </div>
@endif

<script>
    const initialImagePaths = {!! json_encode($initialImagePaths) !!};
    const initialImagePriority = {!! json_encode($initialImagePriority) !!};
    const initialVideoPaths = {!! json_encode($initialLinkPaths) !!};
    const initialVideoPriority = {!! json_encode($initialLinkPriority) !!};
    const onlyOne = {!! json_encode($onlyOne) !!};
</script>

<script src="{{ asset('/js/content_carousel.js') }}"></script>
