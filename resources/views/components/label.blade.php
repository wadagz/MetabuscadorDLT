@props(['value'])

<label {{ $attributes->merge(['class' => 'py-4 mt-4']) }}>
    {{ $value ?? $slot }}
</label>
