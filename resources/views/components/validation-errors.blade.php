@if ($errors->any())
    <div class="max-w-20"{{ $attributes }}>

        <ul class="mt-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
