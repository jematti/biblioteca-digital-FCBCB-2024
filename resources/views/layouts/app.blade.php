<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- hojas de estilos diferentes --}}
    @stack('styles')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Biblioteca') }}</title>

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

        {{-- seccion barra de navegacion --}}
        {{-- @livewire('navigation') --}}
        {{-- fin barra  de navegacion --}}



        {{-- seccion QR de la aplicacion wayruru --}}

        {{-- <div class="text-white flex flex-col rounded-md bg-sky-600 p-2 mb-10 fixed z-10 max-w-xs" >
            <button id="btnMostrar" >
                <p class="mx-1 font-bold p-2">¡Descarga Nuestra <br> Aplicación Wayruru!</p>
                <img class="rounded-xl h-auto p-2 align-middle w-40 width:16rem " alt="imagen de aplicacion wayruru" src="{{ asset('img/iconowayruru.png')}}">
            </button>
        </div>
        <div id="parrafo" class="text-white flex flex-col rounded-md bg-sky-600 p-2 fixed z-10 max-w-xs w-48 width:32rem h-128" >
            <div class="flex flex-row items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                <p class="mx-1 font-bold">¡Descarga con el Codigo QR!</p>
            </div>
            <div class="text-left m-1">

                <img class="rounded-xl h-auto p-2 align-middle w-40 width:16rem " alt="imagen de aplicacion wayruru" src="{{ asset('img/iconowayruru.png')}}">
                <img class="rounded-xl h-auto p-2 align-middle w-40 width:16rem " alt="codigo QR aplicacion wayruru" src="{{ asset('img/app-wayruru-qr.png')}}">
            </div>
            <div class="flex flex-row-reverse gap-2">
                <button id="btnOcultar" class="rounded-md hover:bg-opacity-30 hover:bg-gray-500 transition-all ease-in p-1">Cerrar</button>
            </div>
        </div> --}}



<header class="p-5 border-b bg-sky-800 shadow ">
    <div class="container mx-auto flex justify-between items-center ">
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

                 <a class="font-bold text-gray-200" href="{{route('books.index')}}">
                         Dashboard<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                         </svg>
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



     <div class="max-w-6xl mx-auto px-4">
         <div class="flex justify-between">
             <h1 class="text-3xl font-black text-gray-200 pt-2">
                 <div class="flex space-x-7">
                     <div>
                         <!-- Categoria Libros Populares -->
                         <a href="{{route('home')}}" class="flex items-center py-4 px-2">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                               </svg>
                             <span class="font-bold text-lg pl-2">Libros Populares</span>
                         </a>
                     </div>

                     <div>
                         <!-- Categoria Libros Mas leidos-->
                         <a href="{{route('home')}}" class="flex items-center py-4 px-2">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                               </svg>
                             <span class="font-bold text-lg pl-2">Mas Leidos</span>
                         </a>
                     </div>

                     <div>
                         <!-- Categoria Libros Recomendados -->
                         <a href="{{route('home')}}" class="flex items-center py-4 px-2">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                             </svg>
                             <span class="font-bold text-lg pl-2">Recomendados</span>
                         </a>
                     </div>

                     <div>
                         <!-- Categoria novedades -->
                         <a href="{{route('home')}}" class="flex items-center py-4 px-2">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                               </svg>
                             <span class="font-bold text-lg pl-2">Novedades</span>
                         </a>
                     </div>

                     <div>
                         <!-- Categoria Ofertas -->
                         <a href="{{route('home')}}" class="flex items-center py-4 px-2">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                               </svg>
                             <span class="font-bold text-lg pl-2">Ofertas</span>
                         </a>
                     </div>


                 </div>
             </h1>
         </div>
     </div>

 </header>

        {{-- Seccion para introducir contenido --}}
        <main class="container mx-auto bg-[url('{{ asset('img/por1.jpg')}}')]">
            @yield('contenido')
        </main>


        {{-- Seccion para el footer --}}
        <footer class="text-center p-5 text-gray-500 font-bold uppercase mt-10">
            Fundacion BCB- Todos los derechos reservados {{now()->year}}
        </footer>


    </body>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="http://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"> </script>

        <script type="text/javascript">
            // const $btnOcultar = document.querySelector("#btnOcultar"),
            // $btnMostrar = document.querySelector("#btnMostrar"),
            // $parrafo = document.querySelector("#parrafo");

            // $btnMostrar.addEventListener("click", () => {
            //     $parrafo.style.display = "block";
            // });

            // $btnOcultar.addEventListener("click", () => {
            //     $parrafo.style.display = "none";
            // });
        </script>

        <script>
            $('.actualizar').submit(function(e){
            //previene el comportamiento por defecto del formulario
            e.preventDefault();

            Swal.fire({
            title: '¿Esta Seguro de Actualizar estos Datos?',
            text: "¡Esta accion no es reversible!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, estoy Seguro',
            }).then((result) => {
                if (result.value) {
                    this.submit();
                }
                })
            });
        </script>
        @yield('js')


</html>
