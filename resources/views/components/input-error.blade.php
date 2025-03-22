@props(['for'])

@error($for)
    @foreach ($errors->get($for) as $error)
    <p class="text-red-500">{{ $error }}</p>
    @endforeach
@enderror
