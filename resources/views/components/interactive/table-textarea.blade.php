@props([
    'name',
    'label',
    'value' => '',
    'expandable' => true,
    'editable' => true,
    'rows' => 5
])

<script src="{{asset('js/textarea-expandable.js')}}" defer></script>

<tr>
    <th scope="row" tabindex="0" aria-label="{{$value}}" id="{{$name}}-label">{{$label}}</th>
    <td>
        <button type="button" id="toggle-description" class="w-100"
                {{$expandable ? '' : 'hidden'}}data-label="{{$label}}" data-minimum-rows="{{$rows}}">
            Klap {{$label}} uit
        </button>
        <textarea id="description" class="w-100" rows="{{$rows}}" placeholder="{{$label}}"
                  tabindex="0" name="{{$name}}" {{$editable ? '' : 'disabled'}}>{{old($name) ?: $value}}</textarea>
        <a id="label-name" hidden="hidden">{{$label}}</a>
        <x-situational.error-message error="{{$name}}"/>
    </td>
</tr>
