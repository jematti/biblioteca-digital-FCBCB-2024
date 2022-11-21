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
     <link rel="stylesheet" href="{{ mix('css/app.css') }}">
     <script src="{{ mix('js/app.js') }}" defer></script>

    {{-- Styles Livewire --}}
    @livewireStyles


</head>

    <body>

        {{-- seccion barra de navegacion --}}
        @livewire('navigation')
        {{-- fin de seccion de barra de navegacion --}}

        {{-- Seccion para introducir contenido --}}
        <main>
            @yield('contenido')
        </main>
        {{-- fin de seccion de introducir contenido --}}

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
