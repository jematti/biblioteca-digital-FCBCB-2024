<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Biblioteca') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <style>
        .work-sans {
            font-family: 'Work Sans', sans-serif;
        }

        #menu-toggle:checked + #menu {
            display: block;
        }

        .hover\:grow {
            transition: all 0.3s;
            transform: scale(1);
        }

        .hover\:grow:hover {
            transform: scale(1.02);
        }

        .carousel-open:checked + .carousel-item {
            position: static;
            opacity: 100;
        }

        .carousel-item {
            -webkit-transition: opacity 0.6s ease-out;
            transition: opacity 0.6s ease-out;
        }

        #carousel-1:checked ~ .control-1,
        #carousel-2:checked ~ .control-2,
        #carousel-3:checked ~ .control-3 {
            display: block;
        }

        .carousel-indicators {
            list-style: none;
            margin: 0;
            padding: 0;
            position: absolute;
            bottom: 2%;
            left: 0;
            right: 0;
            text-align: center;
            z-index: 10;
        }

        #carousel-1:checked ~ .control-1 ~ .carousel-indicators li:nth-child(1) .carousel-bullet,
        #carousel-2:checked ~ .control-2 ~ .carousel-indicators li:nth-child(2) .carousel-bullet,
        #carousel-3:checked ~ .control-3 ~ .carousel-indicators li:nth-child(3) .carousel-bullet {
            color: #000;
            /*Set to match the Tailwind colour you want the active one to be */
        }
    </style>


</head>
    <body class="bg-gray-200">
        <header class="p-5 border-b bg-sky-800 shadow">
           <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-black text-gray-200">
                <a href="{{route('home')}}" class="text-3xl font-black">
                    Biblioteca
                </a>
            </h1>


                <!-- Barra de Busqueda -->
            <div class="sm:px-28 lg:px-46 xl:px-40 mx-auto w-5/6">
                <div class="box-wrapper">
                    <div class=" bg-white rounded flex items-center w-full p-3 shadow-sm border border-gray-200">
                        <input type="search" name="" id="" placeholder="Buscar libro por palabra clave / titulo / autor " x-model="q" class="w-full pl-4 text-sm outline-none focus:outline-none bg-transparent">
                        <button  class="outline-none focus:outline-none"><svg class=" w-5 text-gray-600 h-5 cursor-pointer" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
                    </div>
                </div>
            </div>

            {{-- verificacion de autenticacion de usuario --}}
            @auth
                <nav class="flex gap-2 items-center ">
                    <a class="font-bold text-gray-200" href="#">
                        Hola: <span class="font-normal">
                              {{auth()->user()->name}}
                              </span>
                    </a>

                    {{-- metodo para cerrar sesion --}}
                    <form action="{{route('logout')}}" method="POST">
                        @csrf
                        <button type="submit" class="font-bold uppercase text-gray-200 "  >Cerrar Sesión</button>
                    </form>

                </nav>
            @endauth

            @guest
                <nav class="w-1/3 flex gap-2 items-center text-base justify-end">
                    <a class="font-bold text-left text-gray-200 " href="{{route('register')}}">Crear Cuenta</a>
                    <a class="font-bold text-left text-gray-200" href="{{route('login')}}">Login</a>
                </nav>
            @endguest

           </div>
        </header>

        {{-- Seccion para introducir contenido --}}
        <main class="container mx-auto">
            @yield('contenido')
        </main>

        <footer class="text-center p-5 text-gray-500 font-bold uppercase mt-10">
            Fundacion BNB- Todos los derechos reservados {{now()->year}}
        </footer>
    </body>
</html>
