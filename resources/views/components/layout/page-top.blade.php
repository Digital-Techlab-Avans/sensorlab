@props([
    'title' => '',
])

{{--
    The layout of the page title and the buttons above it.
    Single component to improve consistency and responsiveness.
--}}

{{-- Small screen view --}}
<div class="d-sm-none d-flex justify-content-center">
    <div class="text-center">
        <h1 class="mt-3 h-1">{{ $title }}</h1>
        <div class="d-flex mb-2 flex-row justify-content-center">
            {{ $slot }}
        </div>
    </div>
</div>
{{-- Desktop view --}}
<div class="d-none d-sm-flex justify-content-between" style="margin-left: 20vw; margin-right: 20vw;">
    <div class="m-4 d-flex flex-row justify-content-around width-fill">
        <h1 class="h-3">{{ $title }}</h1>
    </div>
    <div class="m-4 me-1 d-flex flex-row justify-content-end width-fill">
        {{ $slot }}
    </div>
</div>
