@props([
    'label',
    'input',
    'div',
])
@php
    $idInput = $input->attributes['id'] ?? $input->attributes['name'];
    $readonly = $input->attributes['readonly'] === "true" ? 'readonly' : '';
    $hidden = $input->attributes['hidden'] === "true" ? 'hidden' : '';
@endphp
<div class="{{$div->attributes['class']}}">
    <label 
    for="{{ $idInput }}" 
    class="form-label {{ $label->attributes['appendClass'] }}" 
    >
    {{ $label }}
    </label>
    <input
        type="{{ $input->attributes['type'] ?? 'text' }}" 
        class="form-control {{ $input->attributes['appendClass'] }}"
        name="{{ $input->attributes['name'] }}" 
        id="{{ $idInput }}"
        value="{{ $input->attributes['value'] }}" 
        placeholder="{{ $input->attributes['placeholder'] ?? '' }}"
        data-content="{{ $label }}"
        {{ $readonly }}
        {{ $hidden }}
    >
</div>
<div class="error-div error-{{$input->attributes['name']}}">
    @if ($errors->has($input->attributes['name']))
        <label id="{{$input->attributes['name']}}-error" class="error" for="{{$input->attributes['name']}}">{{ $errors->first($input->attributes['name']) }}</label>
    @endif
</div>
