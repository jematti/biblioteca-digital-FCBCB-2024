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
            {{-- <div class="p-20 flex flex-col space-y-10 bg-yellow-100">
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
              </div> --}}





              <div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <!--
                  Background backdrop, show/hide based on modal state.

                  Entering: "ease-out duration-300"
                    From: "opacity-0"
                    To: "opacity-100"
                  Leaving: "ease-in duration-200"
                    From: "opacity-100"
                    To: "opacity-0"
                -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity flex justify-center"></div>

                <div class="fixed inset-0 z-10 ">
                  <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <!--
                      Modal panel, show/hide based on modal state.

                      Entering: "ease-out duration-300"
                        From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        To: "opacity-100 translate-y-0 sm:scale-100"
                      Leaving: "ease-in duration-200"
                        From: "opacity-100 translate-y-0 sm:scale-100"
                        To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    -->
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                          <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <!-- Heroicon name: outline/exclamation-triangle -->
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v3.75m-9.303 3.376C1.83 19.126 2.914 21 4.645 21h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 4.88c-.866-1.501-3.032-1.501-3.898 0L2.697 17.626zM12 17.25h.007v.008H12v-.008z" />
                            </svg>
                          </div>
                          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Deactivate account</h3>
                            <div class="mt-2">
                              <p class="text-sm text-gray-500">Are you sure you want to deactivate your account? All of your data will be permanently removed. This action cannot be undone.</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Deactivate</button>
                        <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                      </div>
                    </div>
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
