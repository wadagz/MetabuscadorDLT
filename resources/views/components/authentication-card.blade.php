<div class="container flex items-center justify-center mx-auto min-h-screen">
    <div class="flex flex-col flex-wrap justify-center">
        <div class="mx-auto max-h-20 mb-48">
            {{ $logo }}
        </div>

        <div class="bg-light min-w-full rounded-md shadow-md border border-gray-200">
            {{ $slot }}
        </div>
    </div>
</div>
