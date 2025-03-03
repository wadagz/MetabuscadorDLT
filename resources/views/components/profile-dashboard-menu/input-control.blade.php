@props(['label'])

<div>
    <label class="form-label mt-4">{{ $label }}</label>
    <x-input {{ $attributes }}/>
    <x-input-error for="{{ $attributes->get('name') }}"/>
</div>
