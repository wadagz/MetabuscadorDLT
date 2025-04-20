<nav x-data="{ open: false }" class="navbar navbar-expand-lg bg-primary-500">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('landing') }}" class="bg-light hover:bg-zinc-200 rounded py-2">
                        <span class="mx-2"><b>Metabuscador</b></span>
                        <img src="{{ asset('images/logotipo.png') }}" class="inline h-9 w-auto mr-2" />
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <div class="mr-4">
                        <a href="{{ route('recentlyViewed.index') }}" class="text-black rounded-sm bg-light p-2 hover:bg-neutral-200">Recientes</a>
                    </div>
                    <div class="mr-4">
                        <a href="{{ route('user-favorites.index') }}" class="text-black rounded-sm bg-light p-2 hover:bg-neutral-200">Favoritos</a>
                    </div>
                    <!-- Menú desplegable -->
                    <div class="relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-sm">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 rounded-sm text-black bg-light hover:bg-neutral-200 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            {{ Auth::user()->name }}

                                            <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <!-- Opciones de Perfil, Ayuda y Salir -->
                                <x-dropdown-link href="{{ route('dashboard') }}">
                                    Perfil
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('dashboard') }}">
                                    Ayuda
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-dropdown-link href="{{ route('logout') }}"
                                            @click.prevent="$root.submit();">
                                        Salir
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div>
                        <a href="{{ route('login') }}" class="text-black rounded-sm bg-light p-2 hover:bg-neutral-200 mr-4">Iniciar sesión</a>
                        <a href="{{ route('register') }}" class="text-black rounded-sm bg-light p-2 hover:bg-neutral-200">Registrarse</a>
                    </div>
                @endauth
            </div>

        </div>
    </div>
</nav>
