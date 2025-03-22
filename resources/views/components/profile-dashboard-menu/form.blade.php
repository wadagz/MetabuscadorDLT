@props([
    'legend',
    'action',
    'method',
    'atMethod',
    'btnText',
])

<div class="bs-component">
    <form action='{{ $action }}' method='{{ $method }}'>
        @csrf
        @method($atMethod)
        <fieldset>
             <legend class="text-2xl mb-4">{{ $legend }}</legend>
             <div class="mb-5">
                {{ $slot }}
             </div>
             <x-button type="submit" class="bg-primary-300 text-white px-2 py-1 mb-4">{{ $btnText }}</x-button>
        </fieldset>
    </form>
</div>
