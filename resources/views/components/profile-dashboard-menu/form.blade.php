@props([
    'legend',
    'action',
    'method',
    'atMethod',
    'btnText',
    'btnClass' => 'btn-primary',
    'noDisplayInputs' => false
])

<div class="bs-component">
    <form action='{{ $action }}' method='{{ $method }}'>
        @csrf
        @method($atMethod)
        <fieldset>
             <legend>{{ $legend }}</legend>
             @if (!$noDisplayInputs)
                 <div class="row mb-5">
                    {{ $slot }}
                 </div>
             @endif
             <x-button type="submit" class="{{ $btnClass }}">{{ $btnText }}</x-button>
        </fieldset>
    </form>
</div>
