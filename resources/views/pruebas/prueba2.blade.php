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
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- Styles Livewire --}}
    @livewireStyles


</head>

    <body>
        {{-- seccion barra de navegacion --}}
        @livewire('navigation')

        {{-- Seccion para introducir contenido --}}
            <div class="p-20 flex flex-col space-y-10 bg-yellow-100">
                <h2 class="text-2xl italic">Hoverable Dropdown Menu by KindaCode.com</h2>

                <div>
                    <button class="peer px-5 py-2 bg-green-600 hover:bg-green-700 text-white">Dropdown</button>

                    <!-- the menu here -->
                    <div class="hidden peer-hover:flex hover:flex
                     w-[200px]
                     flex-col bg-white drop-shadow-lg">
                        <a class="px-5 py-3 hover:bg-gray-200" href="#">About Us</a>
                        <a class="px-5 py-3 hover:bg-gray-200" href="#">Contact Us</a>
                        <a class="px-5 py-3 hover:bg-gray-200" href="#">Privacy Policy</a>
                    </div>
                </div>
            </div>

            <div class="space-y-4 bg-white">
                <div x-data="{ activeAccordion: false }">
                  <h3>
                    <button
                      @click="activeAccordion = !activeAccordion"
                      class="flex items-center justify-between w-full p-6 text-white bg-custom-100 rounded-lg"
                    >
                      <h2>Lorem ipsum dolor sit amet consectetur adipisicing elit?</h2>

                      <span
                        :class="{ '-rotate-180': activeAccordion }"
                        class="transition"
                        aria-hidden="true"
                      >
                        👇
                      </span>
                    </button>
                  </h3>

                  <div x-show="activeAccordion" x-collapse class="mt-4">
                    <ul>
                        <li>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. At dolorum
                            tenetur aut doloribus iste? Recusandae ipsam quod modi eligendi
                            perspiciatis voluptatibus fugit, similique tenetur quos quasi impedit
                            totam beatae iure, dolor unde voluptas a veniam adipisci quibusdam qui
                            harum vel! Dolorem quaerat delectus in dignissimos libero, beatae itaque
                            repudiandae! Velit?
                        </li>
                        <li>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. At dolorum
                            tenetur aut doloribus iste? Recusandae ipsam quod modi eligendi
                            perspiciatis voluptatibus fugit, similique tenetur quos quasi impedit
                            totam beatae iure, dolor unde voluptas a veniam adipisci quibusdam qui
                            harum vel! Dolorem quaerat delectus in dignissimos libero, beatae itaque
                            repudiandae! Velit?
                        </li>
                        <li>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. At dolorum
                            tenetur aut doloribus iste? Recusandae ipsam quod modi eligendi
                            perspiciatis voluptatibus fugit, similique tenetur quos quasi impedit
                            totam beatae iure, dolor unde voluptas a veniam adipisci quibusdam qui
                            harum vel! Dolorem quaerat delectus in dignissimos libero, beatae itaque
                            repudiandae! Velit?
                        </li>

                    </ul>
                  </div>
                </div>

                <div x-data="{ activeAccordion: false }">
                  <h3>
                    <button
                      @click="activeAccordion = !activeAccordion"
                      class="flex items-center justify-between w-full p-6 text-white bg-custom-100 rounded-lg"
                    >
                      <h2>Lorem ipsum dolor sit amet?</h2>

                      <span
                        :class="{ '-rotate-180': activeAccordion }"
                        class="transition"
                        aria-hidden="true"
                      >
                        👇
                      </span>
                    </button>
                  </h3>

                  <div x-show="activeAccordion" x-collapse class="mt-4">
                    <p>
                      Lorem ipsum dolor sit amet consectetur, adipisicing elit. Debitis vitae
                      cum non labore itaque veniam exercitationem excepturi dolorum
                      repellendus praesentium!
                    </p>
                  </div>
                </div>
              </div>




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


</html>
