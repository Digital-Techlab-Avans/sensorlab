@props(['modalId', 'title', 'formAction'])
{{--The modal body is wrapped in a form--}}

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="dynamicModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ $formAction }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="dynamicModalLabel">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ $body }}
                </div>
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            </form>
        </div>
    </div>
</div>
