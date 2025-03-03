@props(['for'])

@error($for)
    @foreach ($errors->get($for) as $error)
    <p class="invalid-feedback">{{ $error }}</p>
    @endforeach
@enderror
