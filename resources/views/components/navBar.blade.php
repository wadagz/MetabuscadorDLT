<nav x-data="{ open: false }" class="barra-navegador">
    <div class="objetos-navegador">
        <div class="logo">
            <x-nav-link href="/" class="letras-logo"> MetaBuscador </x-nav-link>
            <x-application-logo class="imagen-logo"/>
        </div>

        <div class="hidden sm:flex sm:items-center sm:ms-6">
            @auth
                <div>
                    <a href="{{ route('login') }}" class="btn btn-info"> Recientes </a>
                    <a href="{{ route('register') }}" class="btn btn-info"> Favoritos </a>
                </div>
                <!-- Menú desplegable -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
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
                <div class="sesion">
                    <li> <a href="{{ route('login') }}" class="btn btn-info"> Iniciar Sesión </a> </li>
                    <li> <a href="{{ route('register') }}" class="btn btn-info"> Registrarse </a> </li>
                </div>
            @endauth
        </div>
    </div>
</nav>