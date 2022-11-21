{{-- barra de nevagacion  --}}
<nav class="sticky w-full top-0 z-50" x-data="{open:false,menu:false, lokasi:false}">

    <div class="bg-custom-100 shadow ">

        <div class="max-w-7xl mx-auto px-2 sm:px-4  ">
            {{-- barra de navegacion principal --}}
            <div class="container flex items-center justify-between h-20">

                {{-- seccion del icono --}}
                <div class="flex items-center px-2 lg:px-0">

                    <a class="flex-shrink-0" href="{{ route('home') }}">
                        <img class="block lg:hidden h-12 w-16" src="{{ asset('img/logo100.png')}}" alt="Logo">
                        <img class="hidden lg:block h-12 w-auto" src="{{ asset('img/logo100.png')}}" alt="Logo">
                    </a>

                </div>

                {{-- barra de busqueda  --}}
                <div class="flex-1">
                    @livewire('search-main')
                </div>

                {{-- icono de inicio de session y login --}}

                @auth

                @can('nav.admin')
                {{-- seccion de barra de neavegacion superior para el administrador  --}}
                <div class="hidden lg:flex lg:ml-2">
                    <div class="flex">
                        <button onclick="location.href = '{{ route('notification') }}'" class="flex items-center w-1/2 px-3 py-1 mx-1 rounded text-center text-sm bg-white font-medium text-black leading-5 hover:bg-gray-600 hover:text-white md:mx-2 md:w-auto">
                            Hola: {{auth()->user()->name}}
                            <span class="ml-2 w-6 h-6 bg-red-500 hover:bg-red-700 rounded-full flex flex-col justify-center items-center text-sm font-bold text-white ">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                        </button>
                        <a class="block w-1/2 px-3 py-2 mx-1 rounded text-center text-sm bg-custom-400 font-medium text-white leading-5 hover:bg-red-600 md:mx-0 md:w-auto" href="{{route('admin.orders.index')}}">Administrador</a>
                        {{-- metodo para cerrar sesion --}}
                        <form action="{{route('logout')}}" method="POST" class="mx-2">
                            @csrf
                            <button type="submit" class="block w-1/2 mx-2 px-1 py-2  rounded text-center text-sm bg-red-500 font-medium text-white leading-5 hover:bg-red-400 md:mx-0 md:w-auto ">Cerrar Sesión</button>
                        </form>

                    </div>
                </div>
                {{-- fin de seccion de barra de navegacio superios para el administrador     --}}
                @endcan

                @can('nav.users')

                {{-- seccion de carro de compras --}}
                @livewire('dropdown-cart')
                {{-- fin de seccion  de carro de compras --}}

                {{-- seccion barra de navegacion superior para el usuario --}}
                <div class="hidden lg:flex lg:ml-2">
                    <div class="flex">
                        {{-- <a class="block w-1/2 px-3 py-2 mx-1 my-2 rounded text-center text-sm bg-white font-medium text-black leading-5 hover:bg-gray-600 hover:text-white md:mx-2 md:w-auto" href="#">
                                Hola: <span class="font-normal">
                                {{auth()->user()->name}}
                        </span>
                        </a> --}}

                        {{-- seccion de icono de perfil de usuario --}}
                        <div class="relative" x-cloak x-data="{ open: false } ">
                            <button @click="open = !open" :class="{ 'font-bold text-custom-100': open === true }" class="flex  px-3 py-2 mx-2  my-4  rounded text-center text-sm bg-custom-500 font-medium text-white leading-5 hover:bg-orange-400 md:mx-0 md:w-auto">
                                Ver Perfil
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="absolute  right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            </button>
                            {{-- lista de opciones de perfil de usuario     --}}
                            <ul x-show="open" @click.away="open = false" class="border border-gray-200 text-gray-600 text-sm  bg-white shadow-md py-1 absolute w-44 right-0 mr-2 divide-y">
                                <li><a href="{{ route('orders.index') }}" class="block px-2 py-1 hover:bg-indigo-100 hover:text-custom-100"> Ordenes de Compra <i class="fa-solid fa-bag-shopping ml-2"></i></a></li>
                                <li><a href="{{ route('perfil.index') }}" class="block px-2 py-1 hover:bg-indigo-100 hover:text-custom-100">Datos Personales<i class="fa-solid fa-pencil ml-2"></i></a></li>
                                <li><a href="{{ route('changepassword') }}" class="block px-2 py-1 hover:bg-indigo-100 hover:text-custom-100">Cambiar Contraseña <i class="fa-solid fa-key ml-2"></i></a></li>
                                <li>
                                    <a href="{{ route('notification') }}" class="flex px-2 py-1 text-base font-semibold hover:bg-indigo-100 hover:text-custom-100">Notificaciones
                                        <span class="ml-2 w-6 h-6 bg-red-500 hover:bg-red-700 rounded-full flex flex-col justify-center items-center text-sm font-bold text-white ">
                                            {{ Auth::user()->unreadNotifications->count() }}
                                        </span>
                                    </a>
                                </li>
                            </ul>
                            {{-- fin de lista de opciones de perfil de usuario --}}
                        </div>
                        {{-- fin de seccion de icono de perfil de usuario --}}

                        {{-- metodo para cerrar sesion --}}
                        <form action="{{route('logout')}}" method="POST" class="mx-4 mt-4">
                            @csrf
                            <button type="submit" class="px-1 py-2 rounded text-center text-sm bg-red-500 font-medium text-white leading-5 hover:bg-red-400 md:mx-0 md:w-auto ">Cerrar Sesión</button>
                        </form>
                        {{-- fin de metodo de cerrar sesion --}}
                    </div>
                </div>
                {{-- fin de seccion de barra de navegacion superior para el usuario --}}

                @endcan

                @endauth

                @guest
                {{-- seccion menu de ingreso al sistema --}}
                <div class="hidden lg:block lg:ml-2">
                    <div class="flex">
                        <a class="block w-1/2 px-3 py-2 mx-1 rounded text-center text-sm bg-white font-medium text-black leading-5 hover:bg-gray-600 hover:text-white md:mx-2 md:w-auto" href="{{ route('login') }}">Ingresa</a>
                        <a class="block w-1/2 px-3 py-2 mx-1 rounded text-center text-sm bg-custom-400 font-medium text-white leading-5 hover:bg-blue-500 md:mx-0 md:w-auto" href="{{ route('register') }}">Registrate</a>
                    </div>
                </div>
                {{-- fin de seccion menu de ingreso al sistema--}}
                @endguest

                {{-- icono de menu desplegable movil --}}
                <div class="flex lg:hidden">
                    <button @click="menu=!menu" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out" aria-label="Main menu" aria-expanded="false">
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                {{-- fin de seccion de menu desplegable movil --}}

            </div>
            {{-- fin barra de navegacion principal --}}
            <hr class="text-custom-400">
            {{-- segunda Barra de navegacion --}}
            <div class="mt-1 py-3 -mx-1  items-end  hidden lg:block text-white  rounded-md">

                <ul class="flex  text-base font-bold ">
                    <li class="px-2 lg:px-3 flex items-center border-r-2 mx-2">
                        <i class="fa-solid fa-house fa-lg px-2"></i>
                        <a href="{{route('home')}}" class="truncate max-w-24 ">Pagina Principal</a>
                    </li>

                    <li class="px-2 lg:px-3 flex items-center bg-custom-500 rounded-lg p-2">
                        <i class="fa-solid fa-magnifying-glass-plus fa-lg px-2"></i>
                        <a href="{{route('filter.index')}}" class="truncate max-w-24 ">Filtro de Busqueda Avanzada</a>
                    </li>


                </ul>
            </div>
            {{-- fin segunda barra de navegacion --}}

        </div>

        {{-- menu para dispositivos moviles --}}

        <div x-show="menu" class="block lg:hidden">
            <div class="px-2 ">
                <a href="{{route('home')}}" class="text-center mt-1 block px-3 py-2 rounded-md text-white font-semibold hover:bg-yellow-500 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Pagina Principal</a>
                <a href="{{route('home')}}" class="text-center mt-1 block px-3 py-2 rounded-md text-white font-semibold hover:bg-yellow-500 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Productos Populares</a>
            </div>
            {{-- inicio y registro para modo celular para el usuario--}}
            @auth
            @can('nav.users')
            <div class="block md:flex items-center py-2 -mx-1 md:mx-0 ">
                <a class="flex justify-center w-full mx-2 my-2  px-1 py-2  rounded text-center text-sm bg-white font-medium leading-5 md:mx-2 md:w-1/2 " href="{{route('perfil.index')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-normal pt-1">
                        Hola: {{auth()->user()->name}}
                    </span>
                </a>
                <a class="flex justify-center w-full mx-2 my-2 px-1 py-2 rounded text-center text-sm bg-white font-medium  leading-5 md:mx-2 md:w-1/2" href="{{route('orders.index')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Ordenes
                </a>
                <a class="flex justify-center w-full mx-2 my-2 px-1 py-2 rounded text-center text-sm bg-white font-medium  leading-5 md:mx-2 md:w-1/2" href="{{route('changepassword')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                    Cambio de Contraseña
                </a>
                <a class="flex w-full mx-2 my-2 px-1 py-2 rounded text-center text-sm bg-white-400 font-medium justify-center border border-white text-white leading-5 md:mx-2 md:w-1/2" href="{{route('orders.index')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    Notificaciones
                    <span class="ml-2 w-6 h-6 bg-red-500 hover:bg-red-700 rounded-full flex flex-col justify-center items-center text-sm font-bold text-white ">
                        {{ Auth::user()->unreadNotifications->count() }}
                    </span>
                </a>
                <form action="{{route('logout')}}" method="POST" class="md:w-1/2">
                    @csrf
                    <button type="submit" class="block w-full mx-2 my-2 px-1 py-2  rounded text-center text-sm bg-red-500 font-medium text-white leading-5 hover:bg-red-400 md:mx-2 md:px-10 md:w-auto">Cerrar Sesión</button>
                </form>
            </div>
            @endcan
            @endauth

            @guest
            <div class="flex items-center py-2 -mx-1 md:mx-0">
                <a class="block w-1/2 px-3 py-2 mx-1 rounded text-center text-sm font-medium hover:text-white leading-5 bg-white hover:bg-gray-600 md:mx-2 md:w-auto" href="{{ route('login') }}">Unete</a>
                <a class="block w-1/2 px-3 py-2 mx-1 rounded text-center text-sm bg-blue-500 font-medium text-white leading-5 hover:bg-blue-600 md:mx-0 md:w-auto" href="{{ route('register') }}">Registrate</a>
            </div>
            @endguest
        </div>
        {{-- fin de menu de dispositivos moviles --}}
    </div>
</nav>
{{-- fin de barra --}}
<style>
    [x-cloak] {
        display: none !important;
    }

</style>
