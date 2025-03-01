@props(['active'])

@php
$classes = ($active ?? false)
            ? 'btn btn-primary'
            : 'btn btn-light';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
