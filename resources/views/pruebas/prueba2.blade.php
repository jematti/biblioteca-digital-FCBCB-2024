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
<!-- Alpine Plugins -->
<script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>

<!-- Alpine Core -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
@livewire('navigation')

<main class="max-w-7xl mx-auto bg-white">
<section class="text-gray-600 body-font overflow-hidden ">
  <div class="container px-5 py-24 mx-auto">
    <div class="lg:w-full flex flex-wrap mx-2 object-center">
      {{-- seccion de la imagen --}}
      <img alt="ecommerce" class="lg:w-1/4 max-w-screen-sm lg:h-72 h-64 object-cover object-center rounded" src="{{ asset('img/PA1.png') }}">
      {{-- seccion informacion del libro --}}
      <div class="lg:w-2/5 w-full lg:pl-5 lg:py-6 lg:pr-2 mt-6 lg:mt-0 ">
        <h1 class="text-gray-900 text-4xl title-font font-medium mb-1">TItulo</h1>
        <h2 class="text-xl title-font text-gray-500 tracking-widest">BRAND NAME</h2>

            <div x-data="{ expanded: false }">


                <p x-show="expanded" x-collapse.min.155px class="leading-relaxed">
                    Fam locavore kickstarter distillery. Mixtape chillwave tumeric sriracha taximy chia microdosing tilde DIY. XOXO fam indxgo juiceramps cornhole raw denim forage brooklyn. Everyday carry +1 seitan poutine tumeric. Gastropub blue bottle austin listicle pour-over, neutra jean shorts keytar banjo tattooed umami cardigan.
                    ¿De dónde viene?
                    Al contrario del pensamiento popular, el texto de Lorem Ipsum no es simplemente texto aleatorio. Tiene sus raices en una pieza cl´sica de la literatura del Latin, que data del año 45 antes de Cristo, haciendo que este adquiera mas de 2000 años de antiguedad. Richard McClintock, un profesor de Latin de la Universidad de Hampden-Sydney en Virginia, encontró una de las palabras más oscuras de la lengua del latín, "consecteur", en un pasaje de Lorem Ipsum, y al seguir leyendo distintos textos del latín, descubrió la fuente indudable. Lorem Ipsum viene de las secciones 1.10.32 y 1.10.33 de "de Finnibus Bonorum et Malorum" (Los Extremos del Bien y El Mal) por Cicero, escrito en el año 45 antes de Cristo. Este libro es un tratado de teoría de éticas, muy popular durante el Renacimiento. La primera linea del Lorem Ipsum, "Lorem ipsum dolor sit amet..", viene de una linea en la sección 1.10.32
                    El trozo de texto estándar de Lorem Ipsum usado desde el año 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de "de Finibus Bonorum et Malorum" por Cicero son también reproducidas en su forma original exacta, acompañadas por versiones en Inglés de la traducción realizada en 1914 por H. Rackham.
                </p>
                <button @click="expanded = ! expanded" class=" my-3 px-3 py-2 text-base font-medium text-center text-blue-700 underline ">Ver mas</button>
            </div>
        <hr class="mb-2">
        <div class="flex">
            <h4 class="font-medium mx-4">Categoria:</h4>
          <button class="flex text-white bg-green-700 border-0 py-2 px-6 focus:outline-none hover:bg-green-600 rounded"> Button</button>
        </div>
      </div>
      {{-- seccion de ubicacion del libro --}}
      <div class="lg:w-1/3 w-full lg:pl-2 lg:py-6 mt-6 lg:mt-0 border-l border-gray-900 ">
        <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">Caracteristicas</h1>
            {{-- Tabla de datos del libro --}}

            <div class="block overflow-x-auto pb-4">
                <table>
                <tbody>
                    <tr>
                    <th class="align-middle text-lg pl-1  text-left text-blueGray-700 ">
                        idioma:
                    </th>
                    <td class="align-middle text-lg pl-1 pr-10 text-left text-blueGray-700 ">
                        {{-- {{ $book->idioma }} --}} 123
                    </td>
                    <th class="align-middle text-lg pl-1 text-left text-blueGray-700 ">
                        Fecha Publicación:
                    </th>
                    <td class="align-middle text-lg pl-1 text-left text-blueGray-700 ">
                        {{-- {{ $book->fecha_publicacion }} --}}123
                    </td>
                    </tr>
                </tbody>

                </table>
            </div>


            {{-- informacion de envio  --}}
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 text-left"  role="alert">

                <h5 class="text-gray-900 text-xl font-bold mb-2">Disponible en las Sucursales: </h5>

                    <button class="bg-blue-600 text-white mx-5  font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="toggleModal('modal-id-lp')">
                        {{-- {{ $book->repository->ciudad}} --}} ciudad
                    </button>
            </div>
      </div>
    </div>
  </div>
</section>
</main>


</body>
