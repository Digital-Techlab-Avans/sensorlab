@props(['name', 'value' => null, 'type' => 'text', 'min' => 0, 'placeholder' => null, 'required' => false])


<input class="w-100 form-control-plaintext rounded-1 border-1 border-dark p-1" name="{{$name}}" value="{{$value}}" type="{{$type}}" placeholder="{{$placeholder}}"
    {{$required ?? 'required'}} @if($type == 'number') min="{{$min}}"@endif>
<x-situational.error-message error="{{$name}}"/>
