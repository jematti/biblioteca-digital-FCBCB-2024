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

        @livewire('navigation')
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


        {{-- Seccion para introducir contenido --}}
        <main class="max-w-7xl mx-auto">
            @yield('contenido')
        </main>


        {{-- Seccion para el footer --}}
        @livewire('footer')


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
