@props([
    'legend',
    'action',
    'method',
    'atMethod',
    'btnText',
    'btnClass' => 'btn-primary',
])

<div class="bs-component">
    <form action='{{ $action }}' method='{{ $method }}'>
        @csrf
        @method($atMethod)
        <fieldset>
             <legend>{{ $legend }}</legend>
             <div class="row mb-5">
                {{ $slot }}
             </div>
             <x-button type="submit" class="{{ $btnClass }}">{{ $btnText }}</x-button>
        </fieldset>
    </form>
</div>
