@props(['errorBag' => null, 'for'])

@error($for, $errorBag ?? '')
    <p class="invalid-feedback">{{ $message }}</p>
@enderror
