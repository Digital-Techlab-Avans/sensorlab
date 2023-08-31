@props(['name', 'label' => null, 'value' => null, 'checked' => false, 'disabled' => false])
<div class="form-check">
    <input type="checkbox" class="form-check-input" name="{{$name}}" id="{{$name}}" value="{{true}}" @if($checked) checked @endif @if($disabled) disabled @endif>
    @if($label)
        <label class="form-check-label" for="{{$name}}">{{$label}}</label>
    @endif
    <x-situational.error-message error="{{$name}}"/>
</div>
