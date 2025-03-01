@props(['label', 'errorBag' => null])

<div>
    <label class="form-label mt-4">{{ $label }}</label>
    <x-input {{ $attributes }}/>
    <x-input-error errorBag="{{ $errorBag }}" for="{{ $attributes->get('name') }}"/>
</div>
