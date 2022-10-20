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

        <div class="pt-10" id="loadingDiv">
            <div class="loader">Loading...
            </div>
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

        <script>
        //    $('body').append('<div style="" id="loadingDiv"><div class="loader">Loading...</div></div>');
            $(window).on('load', function(){
            setTimeout(removeLoader, 2000); //wait for page load PLUS two seconds.
            });
            function removeLoader(){
                $( "#loadingDiv" ).fadeOut(500, function() {
                // fadeOut complete. Remove the loading div
                $( "#loadingDiv" ).remove(); //makes page more lightweight
            });
            }
        </script>
        @yield('js')


</html>
