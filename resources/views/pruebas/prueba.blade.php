<!DOCTYPE html>
<html lang="en">

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

    {{-- <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,400&display=swap" rel="stylesheet"> --}}



</head>

<body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
    <div class="container px-5 py-24 mx-auto">
        <div class="lg:w-1/8 mx-auto flex flex-wrap">
          <img alt="ecommerce" class="lg:w-1/4 w-full lg:h-auto h-64 object-cover object-center rounded" src="https://dummyimage.com/400x400">
          <div class="lg:w-2/5 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
            <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">Titulo del Libro</h1>
            <h2 class="text-sm title-font text-gray-500 tracking-widest">Nombre de autor</h2>

            <p class="leading-relaxed">Fam locavore kickstarter distillery. Mixtape chillwave tumeric sriracha taximy chia microdosing tilde DIY. XOXO fam indxgo juiceramps cornhole raw denim forage brooklyn. Everyday carry +1 seitan poutine tumeric. Gastropub blue bottle austin listicle pour-over, neutra jean shorts keytar banjo tattooed umami cardigan.</p>
            <div class="flex mt-6 items-center pb-5 border-b-2 border-blue-100 mb-5">
              <div class="flex ml-6 items-center">
                <span class="mr-3">Categoria</span>
              </div>
            </div>

        </div>

        <div class="lg:w-1/4 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
            <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">Precio Final del Libro</h1>
            <h2 class="text-sm title-font text-gray-500 tracking-widest">Porcentaje de Descuento</h2>

            <span class="title-font font-medium text-2xl text-gray-900">$58.00</span>
            <div class="mt-6 items-center pb-5 border-b-2 border-gray-100 mb-5">
              <div class=" ml-6 items-center">
                <svg class="h-8 w-8 text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r="9" />  <path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1 -1.8 -1" />  <path d="M12 6v2m0 8v2" /></svg>
                <p class="mr-3">Costo de Envio</p>
               <svg class="h-8 w-8 text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="7" cy="17" r="2" />  <circle cx="17" cy="17" r="2" />  <path d="M5 17h-2v-11a1 1 0 0 1 1 -1h9v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" /></svg>
                <p class="mr-3">Lugar de Envio</p>
              </div>
            </div>

            <div class="flex">
                <button class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-700 focus:outline-none focus:bg-red-700">
                    <svg class="w-5 h-5 mx-1" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                    </svg>
                    <span class="mx-1">Añadir Compra</span>
                </button>
            </div>
            <div class="flex">
                <button class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-orange-400 rounded-md hover:bg-orange-700 focus:outline-none focus:bg-orange-700">
                    <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path>
                    </svg>
                    <span class="mx-1">Guardar </span>
                </button>

            </div>
        </div>


        </div>
    </div>

</body>

</html>
