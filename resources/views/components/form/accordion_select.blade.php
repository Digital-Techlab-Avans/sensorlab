@props([
    'options',
    'subject',
    'default_key',
    'selected_key',
])


@foreach($options as $option_key => $option_value)
    @php($is_selected = $option_key == $selected_key)
    <div class="d-flex align-items-center">
        <div class="col-1 mt-n3 mb-n3">
            <span id="check{{$option_key}}" class="{{ ($is_selected) ? 'd-inline' : 'd-none' }} bi bi-check fs-3 text-warning"></span>
            <label for="{{$subject}}{{$option_key}}"></label>
        </div>
        <div class="col-11 d-flex">
            <label class="ml-2 align-self-start" for="{{$subject}}{{$option_key}}">
                {{ $option_value }}
            </label>
        </div>
        @php($default = $option_key == ($default_key ?? '-') ? 'true' : 'false')
        <input class="accordion-select-input" type="radio" id="{{$subject}}{{$option_key}}" name="{{$subject}}" value="{{$option_key}}" data-defaultkey="{{ $default }}" {{ $is_selected ? 'checked' : '' }} onchange="this.form.submit()" style="display: none;">
    </div>
@endforeach
