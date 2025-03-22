@props(['label'])

<div class="mb-4">
    <label>{{ $label }}</label>
    <x-input class="mt-2 w-1/2" {{ $attributes }}/>
    <x-input-error for="{{ $attributes->get('name') }}"/>
</div>
