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
                        <div class="hidden lg:block lg:ml-2">
                            <div class="flex">
                                <a class="block w-1/2 px-3 py-2 mx-1 rounded text-center text-sm bg-white font-medium text-black leading-5 hover:bg-gray-600 hover:text-white md:mx-2 md:w-auto" href="#">
                                    Hola: <span class="font-normal">
                                        {{auth()->user()->name}}
                                    </span>
                                </a>
                                <a class="block w-1/2 px-3 py-2 mx-1 rounded text-center text-sm bg-custom-400 font-medium text-white leading-5 hover:bg-blue-600 md:mx-0 md:w-auto" href="{{route('admin.orders.index')}}">Administrador</a>
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
                                        <a href="#" @click="open = !open" :class="{ 'font-bold text-custom-100': open === true }" class="flex  px-3 py-2 mx-1 my-4 rounded text-center text-sm bg-custom-500 font-medium text-white leading-5 hover:bg-orange-400 md:mx-0 md:w-auto">Ver Perfil
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </a>
                                    <ul x-show="open" @click.away="open = false" class="border border-gray-200 text-gray-600 text-sm  bg-white shadow-md py-1 absolute w-44 right-0 mr-2 divide-y">
                                      <li><a href="{{ route('orders.index') }}" class="block px-2 py-1 hover:bg-indigo-100 hover:text-custom-100"> Ordenes de Compra <i class="fa-solid fa-bag-shopping ml-2"></i></a></li>
                                      <li><a href="{{ route('perfil.index') }}" class="block px-2 py-1 hover:bg-indigo-100 hover:text-custom-100">Datos Personales<i class="fa-solid fa-pencil ml-2"></i></a></li>
                                      <li><a href="{{ route('changepassword') }}" class="block px-2 py-1 hover:bg-indigo-100 hover:text-custom-100">Cambiar Contraseña <i class="fa-solid fa-key ml-2"></i></a></li>
                                    </ul>
                                </div>
                                {{-- fin de seccion de icono de perfil de usuario --}}

                                {{-- metodo para cerrar sesion --}}
                                <form action="{{route('logout')}}" method="POST" class="mx-2 mt-4">
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
                    <li class="px-2 lg:px-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        <a href="{{route('home')}}" class="truncate max-w-24 ">Pagina Principal</a>
                    </li>

                    <li class="px-2 lg:px-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        <a href="{{route('home')}}" class="truncate max-w-24 ">Novedades</a>
                    </li>
                    {{-- <li class="px-2 lg:px-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                        <a href="{{route('home')}}" class="truncate max-w-24 ">Recomendados</a>
                    </li>
                    <li class="px-2 lg:px-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <a href="{{route('home')}}" class="truncate max-w-24 ">Los Más Vistos</a>
                    </li> --}}
                </ul>
            </div>
            {{-- fin segunda barra de navegacion --}}

        </div>

        {{-- menu para dispositivos moviles --}}

        <div x-show="menu" class="block lg:hidden">
            <div class="px-2 pt-2 pb-3">
                <a href="{{route('home')}}" class="mt-1 block px-3 py-2 rounded-md text-white font-semibold hover:bg-yellow-500 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Novedades</a>
                <a href="{{route('home')}}" class="mt-1 block px-3 py-2 rounded-md text-white font-semibold hover:bg-yellow-500 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Recomendados </a>
                <a href="{{route('home')}}" class="mt-1 block px-3 py-2 rounded-md text-white font-semibold hover:bg-yellow-500 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Los más vistos</a>

            </div>
            {{-- inicio y registro para modo celular --}}
            @auth
                @can('nav.users')
                <div class="block md:flex items-center py-2 -mx-1 md:mx-0 ">
                    <a class="block w-full mx-2 my-2  px-1 py-2  rounded text-center text-sm bg-white font-medium hover:text-white leading-5 hover:bg-gray-600 md:mx-2 md:w-1/2 " href="#">
                        Hola: <span class="font-normal">
                            {{auth()->user()->name}}
                        </span>
                    </a>
                    <a class="block w-full mx-2 my-2 px-1 py-2 rounded text-center text-sm bg-custom-400 font-medium text-white leading-5 hover:bg-blue-500 md:mx-2 md:w-1/2" href="{{route('orders.index')}}">
                        Ver Perfil
                    </a>
                    <form action="{{route('logout')}}" method="POST" class="md:w-1/2">
                        @csrf
                        <button type="submit" class="block w-full mx-2 my-2 px-1 py-2  rounded text-center text-sm bg-custom-200 font-medium text-white leading-5 hover:bg-red-400 md:mx-2 md:px-10 md:w-auto">Cerrar Sesión</button>
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
