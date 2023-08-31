@php
    $lang_file = 'loaner.toast.';
@endphp

<div class="alert alert-secondary alert-dismissible text-center  show position-fixed start-50 translate-middle bg-light"
     id="alert-card" style="display: none;" aria-live="assertive">
    <div class="alert-content">
        <p id="alert-text" class="fs-6 fs-md-2" aria-atomic="true"></p>
        <a class="btn btn-primary mb-4" id="checkout-button" style="display: none" href="{{ route('loaning_checkout') }}">{{ __($lang_file . 'go_to_checkout') }}</a>
        <button type="button" class="btn-close" data-bs-dismiss="hide" aria-label="Sluiten"></button>
    </div>
    <div class="progress">
        <div class="progress-bar" role="progressbar" id="progress-bar"></div>
    </div>
</div>
