<div>
    <form action="{{ route('user-preferences.store') }}" method="POST">
        @csrf
    <div class="grid grid-cols-3">
        <div class="col-start-1 col-span-2">
            <div class="mb-4">
            <legend class="text-xl">¿Qué tipo de ambiente prefieres en tu alojamiento?</legend>
            @foreach($pregunta1 as $preferencia)
                <div class="mt-2 ml-8"">
                    <input type="checkbox" id="{{$preferencia['nombre']}}" name="{{$preferencia['nombre']}}" value="{{ $preferencia['id'] }}" @checked($currentPreferences->contains($preferencia['id']))>
                    <label for="{{$preferencia['nombre']}}">{{ $preferencia['descripcion'] }}</label>
                </div>
            @endforeach
            </div>

            <div class="mb-4">
            <legend class="text-xl">¿Qué servicios son más importantes para ti al elegir un alojamiento?</legend>
            @foreach($pregunta2 as $preferencia)
                <div class="mt-2 ml-8">
                    <input type="checkbox" id="{{$preferencia['nombre']}}" name="{{$preferencia['nombre']}}" value="{{ $preferencia['id'] }}" @checked($currentPreferences->contains($preferencia['id']))>
                    <label for="{{$preferencia['nombre']}}">{{ $preferencia['descripcion'] }}</label>
                </div>
            @endforeach
            </div>

            <div class="mb-4">
            <legend class="text-xl">¿Qué tan importante es el precio para ti al elegir un alojamiento?</legend>
            @foreach($pregunta3 as $preferencia)
                <div class="mt-2 ml-8">
                    <input type="checkbox" id="{{$preferencia['nombre']}}" name="{{$preferencia['nombre']}}" value="{{ $preferencia['id'] }}" @checked($currentPreferences->contains($preferencia['id']))>
                    <label for="{{$preferencia['nombre']}}">{{ $preferencia['descripcion'] }}</label>
                </div>
            @endforeach
            </div>

            <div class="mb-4">
            <legend class="text-xl">¿Qué tan importante es la sostenibilidad para ti al elegir un alojamiento?</legend>
            @foreach($pregunta4 as $preferencia)
                <div class="mt-2 ml-8">
                    <input type="checkbox" id="{{$preferencia['nombre']}}" name="{{$preferencia['nombre']}}" value="{{ $preferencia['id'] }}" @checked($currentPreferences->contains($preferencia['id']))>
                    <label for="{{$preferencia['nombre']}}">{{ $preferencia['descripcion'] }}</label>
                </div>
            @endforeach
            </div>

            <div class="mb-4">
            <legend class="text-xl">¿Qué tan importante es la accesibilidad para ti al elegir un alojamiento?</legend>
            @foreach($pregunta5 as $preferencia)
                <div class="mt-2 ml-8">
                    <input type="checkbox" id="{{$preferencia['nombre']}}" name="{{$preferencia['nombre']}}" value="{{ $preferencia['id'] }}" @checked($currentPreferences->contains($preferencia['id']))>
                    <label for="{{$preferencia['nombre']}}">{{ $preferencia['descripcion'] }}</label>
                </div>
            @endforeach
            </div>
        </div>

        <div class="col-start-3">
            <button class="rounded-sm bg-primary-500 text-white px-2 py-2" type="submit">Actualizar mis preferencias</button>
        </div>
    </div>
    </form>
</div>
