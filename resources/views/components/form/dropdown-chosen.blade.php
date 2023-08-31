@props([
    'name',
    'options',
    'selected' => null,
    'multiple' => false,
    'submitOnChange' => false,
    'valueColumn' => 'id',
    'labelColumn' => 'name',
    'defaultText' => 'Selecteer een optie',
    'size' => 5,
])

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
<script src="{{ asset('/js/chosen_category.js') }}"></script>

<div class="form-group">
    <select data-placeholder="{{$defaultText}}" name="{{$name}}"
            class="select2 form-control" {{ $attributes->merge(['multiple' => $multiple]) }}>
        @foreach ($options as $option)
            @php
                $isSelected = in_array($option[$valueColumn], array_column($selected ?? [], $valueColumn));
            @endphp
            <option value="{{ $option[$valueColumn] }}" {{ $isSelected ? 'selected' : '' }}>
                {{ $option[$labelColumn] }}
            </option>
        @endforeach
    </select>
</div>
