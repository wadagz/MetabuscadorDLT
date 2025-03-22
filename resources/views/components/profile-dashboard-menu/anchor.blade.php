@props(['active'])

@php
$classes = ($active ?? false)
            ? 'bg-primary-500 rounded-md px-2 py-1 text-white text-center'
            : 'bg-white rounded-md px-2 py-1 border border-primary-500 text-primary-500 text-center transition duration-300 hover:bg-[#5f80a3] hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
