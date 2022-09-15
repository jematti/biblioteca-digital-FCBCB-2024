<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'Libreria Virtual FC-BCB') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- hojas de estilos diferentes --}}
    @stack('styles')

     <!-- Styles - Scripts -->
     @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Styles Livewire --}}
    @livewireStyles
    <style>
        .loader {
	border-top-color: #3498db;
	-webkit-animation: spinner 1.5s linear infinite;
	animation: spinner 1.5s linear infinite;
}

@-webkit-keyframes spinner {
	0% {
		-webkit-transform: rotate(0deg);
	}
	100% {
		-webkit-transform: rotate(360deg);
	}
}

@keyframes spinner {
	0% {
		transform: rotate(0deg);
	}
	100% {
		transform: rotate(360deg);
	}
}

    </style>

</head>

    <body>
        {{-- Seccion de mensajes flash --}}
        {{-- <div>
            @if (session()->has('message'))
                <div class="alert alert-success p-10 m-10 text-white">
                    {{ session('message') }}
                </div>
            @endif
        </div> --}}
        {{-- fin de seccion de mensajes flash --}}

        <div wire:loading class="fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-700 opacity-75 flex flex-col items-center justify-center">
            <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
            <h2 class="text-center text-white text-xl font-semibold">Loading...</h2>
            <p class="w-1/3 text-center text-white">This may take a few seconds, please don't close this page.</p>
        </div>

        {{-- seccion barra de navegacion --}}
        @livewire('navigation')

        {{-- Seccion para introducir contenido --}}
        <main>
            @yield('contenido')
        </main>
    </body>

        <!-- Scripts Livewire -->
        @livewireScripts

        {{-- enlace a archivos js --}}
        <script src="{{ asset('js/app.js') }}" defer ></script>

        {{-- Sweet Alert --}}
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

         {{-- jquery --}}
        <script src="http://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"> </script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/blitzer/jquery-ui.css" type="text/css" />
        <script src="jquery.easy-confirm-dialog.js"></script>


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
