@props(['value'])

<label {{ $attributes->merge(['class' => 'form-label mt-4']) }}>
    {{ $value ?? $slot }}
</label>
