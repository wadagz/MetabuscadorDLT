@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block rounded-sm border border-gray-300 transition duration-300 focus:ring-2 focus:ring-info']) !!}>
