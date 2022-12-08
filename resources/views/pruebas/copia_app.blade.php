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
    {{-- scripts de laravel mis por si se requiere --}}
    {{-- <script src="{{ mix('js/app.js') }}" defer></script> --}}

    {{-- Styles Livewire --}}
    @livewireStyles


</head>

<body>
    {{-- seccion barra de navegacion --}}
    @livewire('navigation')

    <div class="bg-white">

        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus imperdiet, nulla et dictum interdum, nisi lorem egestas vitae scel<span id="dots">...</span><span id="more">erisque enim ligula venenatis dolor. Maecenas nisl est, ultrices nec congue eget, auctor vitae massa. Fusce luctus vestibulum augue ut aliquet. Nunc sagittis dictum nisi, sed ullamcorper ipsum dignissim ac. In at libero sed nunc venenatis imperdiet sed ornare turpis. Donec vitae dui eget tellus gravida venenatis. Integer fringilla congue eros non fermentum. Sed dapibus pulvinar nibh tempor porta.</span></p>
        <button onclick="myFunction()" id="myBtn">Read more</button>


        <p x-data="{ isCollapsed: false, maxLength: 50, originalContent: '', content: '' }" x-init="originalContent = $el.firstElementChild.textContent.trim(); content = originalContent.slice(0, maxLength)" class="text-justify mr-2">
            <span x-text="isCollapsed ? originalContent : content">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi ducimus tempora iste maxime eligendi placeat minus obcaecati consequatur repudiandae, voluptas veniam aperiam nisi rerum natus voluptatibus, deserunt nostrum ut! Nesciunt.
            </span>
            ...
            <button @click="isCollapsed = !isCollapsed" x-show="originalContent.length > maxLength" x-text="isCollapsed ? 'Ver menos' : 'Ver mas'" class="font-semibold text-gray-500 underline"></button>
        </p>
    </div>


</body>
<!-- Scripts Livewire -->
@livewireScripts

{{-- <script src="{{ mix('js/app.js') }}" defer></script> --}}

{{-- enlace a archivos js --}}
<script src="{{ asset('js/app.js') }}" defer></script>

{{-- Sweet Alert --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- jquery --}}
<script src="http://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"> </script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/blitzer/jquery-ui.css" type="text/css" />
<script src="jquery.easy-confirm-dialog.js"></script>


<script>
    $('.actualizar').submit(function(e) {
        //previene el comportamiento por defecto del formulario
        e.preventDefault();

        Swal.fire({
            title: '¿Esta Seguro de Actualizar estos Datos?'
            , text: "¡Esta accion no es reversible!"
            , icon: 'warning'
            , showCancelButton: true
            , confirmButtonColor: '#3085d6'
            , cancelButtonColor: '#d33'
            , confirmButtonText: 'Si, estoy Seguro'
        , }).then((result) => {
            if (result.value) {
                this.submit();
            }
        })
    });

</script>
@yield('js')



</html>
