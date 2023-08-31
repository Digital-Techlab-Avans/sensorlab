@props([
    'name',
    'options',
    'selected' => null,
    'multiple' => false,
    'submitOnChange' => false,
    'valueColumn' => 'id',
    'labelColumn' => 'name',
    'defaultText' => null,
    'size' => 5,
])

<select name="{{ $name }}" class="form-select mt-2" {{ $attributes->merge(['multiple' => $multiple]) }}>
    @if(!empty($defaultText))
        <option value="" style="font-size: 1.2rem;">{{$defaultText}}</option>
    @endif
    @if(is_a($options, 'Illuminate\Database\Eloquent\Collection'))
        @foreach ($options as $option)
            <option value="{{ $option[$valueColumn] }}" {{ $selected == $option[$valueColumn] || empty($defaultText) && $loop->first ? 'selected' : '' }} style="font-size: 1.2rem;">
                {{ $option[$labelColumn] }}
            </option>
        @endforeach
    @else
        @foreach($options as $option => $option_text)
            <option value="{{ $option }}" {{ $selected == $option || empty($defaultText) && $loop->first ? 'selected' : '' }} style="font-size: 1.2rem;">
                {{ $option_text  }}
            </option>
        @endforeach
    @endif
</select>

@if ($submitOnChange)
    <script>
        document.querySelector('[name="{{ $name }}"]').addEventListener('change', function () {
            this.form.submit();
        });
    </script>
@endif
