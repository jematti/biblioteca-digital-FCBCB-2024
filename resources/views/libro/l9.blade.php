@extends('layouts.app')


@section('contenido')

<body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
    <div class="container px-5 mx-auto bg-white">

        {{-- seccion de libro --}}
        <div class="md:flex md:justify-center md:gap md:items-center">

          <div class="md:w-3/12  p-5">
                <img alt="ecommerce" src="{{ asset('img/PA9.png')}}">
          </div>

          <div class="md:w-9/12 p-6 rounded-lg shadow-xl">
                <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">
                    Dossier Ricardo
                    Perez Alcalá
                    </h1>
                <h2 class="text-lg title-font text-gray-500 tracking-widest">Revista Nacional Piedra de Agua</h2>

                <p class="leading-relaxed">
                    Este noveno número de Piedra de agua, dedica su
                    Dossier al desaparecido maestro Ricardo Pérez Alcalá. Dueño de una maestría singular en el manejo
                    de la acuarela, supo también crear obras maestras en otras
                    técnicas y artes como la escultura y la arquitectura.
                    Artistas plásticos, escritores, críticos de arte y gestores
                    culturales abordan desde diferentes perspectivas su obra,
                    a propósito –no de su sentido fallecimiento– sino de la
                    construcción de su memoria y valorización de su legado.
                </p>
                <div class="flex mt-6 items-center pb-5 border-b-2 border-blue-100 mb-5">
                    <h4 class="font-medium mb-1">Categoria:</h4>
                    <div class="flex ml-6 items-center">
                        <button type="button" class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">REVISTA</button>
                    </div>
                </div>

                {{-- Tabla de datos del libro --}}

                <div class="block overflow-x-auto pb-4">
                    <table>
                      <tbody>
                        <tr>
                          <th class="align-middle text-lg pl-1  text-left text-blueGray-700 ">
                            idioma:
                          </th>
                          <td class="align-middle text-lg pl-1 pr-10 text-left text-blueGray-700 ">
                            Español
                          </td>
                          <th class="align-middle text-lg pl-1 text-left text-blueGray-700 ">
                            año:
                          </th>
                          <td class="align-middle text-lg pl-1 text-left text-blueGray-700 ">
                            2014
                          </td>
                        </tr>
                      </tbody>

                    </table>
                  </div>


                {{-- informacion de envio  --}}
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 text-center"  role="alert">
                    <div class="p-2">
                     <h5 class="text-gray-900 text-xl font-bold mb-2">Disponible en las Sucursales: </h5>

                        <button class="bg-blue-600 text-white mx-5  font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="toggleModal('modal-id-lp')">
                            La Paz
                        </button>
                        <button class="bg-blue-600 text-white mx-5 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="toggleModal('modal-id-sc')">
                            Sucre
                        </button>
                        <button class="bg-blue-600 text-white mx-5 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="toggleModal('modal-id-or')">
                            Oruro
                        </button>

                    </div>

                    {{-- <div class="py-3 px-6 border-t border-gray-300 text-gray-600 uppercase font-bold text-center" >
                        Tiempo estimado de Envio es de 3 dias a partir de la compra
                    </div> --}}
                </div>
          </div>
        </div>

        {{-- seccion de compra --}}
        {{-- <div class="lg:w-1/4 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
            <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">Precio Final del Libro</h1>
            <h2 class="text-sm title-font text-gray-500 tracking-widest">Porcentaje de Descuento 10% Por Comprar Online</h2>

            <span class="title-font font-medium text-2xl text-gray-900">Bs. 58.00</span>

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
        </div> --}}

    </div>


    {{-- Codigo Modal La Paz--}}
      <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="modal-id-lp">
        <div class="relative w-auto my-6 mx-auto max-w-3xl">
          <!--content-->
          <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
            <!--header-->
            <div class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
              <h3 class="text-3xl font-semibold">
                Contactanos en la Ciudad de La Paz
              </h3>
              <button class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none" onclick="toggleModal('modal-id-lp')">
                <span class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                  ×
                </span>
              </button>
            </div>
            <!--body-->
            <div class="flex flex-col p-6">
                <div class="flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-5 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <p class="font-medium my-4 text-black text-xl leading-relaxed mx-1 ">
                        Correo: ejemplo@ejemplo.com
                    </p>
                </div>
                <div class="flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <p class="font-medium my-4 text-black text-xl leading-relaxed mx-1 ">
                        Celulares: 244-196
                    </p>
                </div>
                <div class="flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="font-medium my-4 text-black text-xl leading-relaxed mx-1 ">
                        Encargado: Jhon Smith
                    </p>
                </div>
                <div class="flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p class="font-medium my-4 text-black text-xl leading-relaxed mx-1 ">
                        Ubicación:
                    </p>
                </div>
                <div>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1912.6677131703736!2d-68.12918784562898!3d-16.509155279017744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x915f21b7e47521e1%3A0x7fa0fb5d64caf2f2!2sFUNDACI%C3%93N%20CULTURAL%20DEL%20BANCO%20CENTRAL%20DE%20BOLIVIA!5e0!3m2!1ses-419!2sbo!4v1654261936603!5m2!1ses-419!2sbo" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>


            <!--footer-->
            <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
              <button class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="toggleModal('modal-id-lp')">
                Cerrar
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-lp-backdrop"></div>

      {{-- Codigo Modal Sucre--}}

      <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="modal-id-sc">
        <div class="relative w-auto my-6 mx-auto max-w-3xl">
          <!--content-->
          <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
            <!--header-->
            <div class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
              <h3 class="text-3xl font-semibold">
                Contactanos en la Ciudad de Sucre
              </h3>
              <button class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none" onclick="toggleModal('modal-id-sc')">
                <span class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                  ×
                </span>
              </button>
            </div>
            <!--body-->
            <div class="flex flex-col p-6">
                <div class="flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-5 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <p class="font-medium my-4 text-black text-xl leading-relaxed mx-1 ">
                        Correo: ejemplo@ejemplo.com
                    </p>
                </div>
                <div class="flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <p class="font-medium my-4 text-black text-xl leading-relaxed mx-1 ">
                        Celulares: 244-196
                    </p>
                </div>
                <div class="flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="font-medium my-4 text-black text-xl leading-relaxed mx-1 ">
                        Encargado: Jhon Smith
                    </p>
                </div>
                <div class="flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p class="font-medium my-4 text-black text-xl leading-relaxed mx-1 ">
                        Ubicación:
                    </p>
                </div>
                <div>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1912.6677131703736!2d-68.12918784562898!3d-16.509155279017744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x915f21b7e47521e1%3A0x7fa0fb5d64caf2f2!2sFUNDACI%C3%93N%20CULTURAL%20DEL%20BANCO%20CENTRAL%20DE%20BOLIVIA!5e0!3m2!1ses-419!2sbo!4v1654261936603!5m2!1ses-419!2sbo" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <!--footer-->
            <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
              <button class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="toggleModal('modal-id-sc')">
                Cerrar
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-sc-backdrop"></div>

    {{-- Codigo Modal Oruro--}}

      <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="modal-id-or">
        <div class="relative w-auto my-6 mx-auto max-w-3xl">
          <!--content-->
          <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
            <!--header-->
            <div class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
              <h3 class="text-3xl font-semibold">
                Contactanos en la Ciudad de Oruro
              </h3>
              <button class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none" onclick="toggleModal('modal-id-or')">
                <span class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                  ×
                </span>
              </button>
            </div>
            <!--body-->
            <div class="flex flex-col p-6">
                <div class="flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-5 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <p class="font-medium my-4 text-black text-xl leading-relaxed mx-1 ">
                        Correo: ejemplo@ejemplo.com
                    </p>
                </div>
                <div class="flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <p class="font-medium my-4 text-black text-xl leading-relaxed mx-1 ">
                        Celulares: 244-196
                    </p>
                </div>
                <div class="flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="font-medium my-4 text-black text-xl leading-relaxed mx-1 ">
                        Encargado: Jhon Smith
                    </p>
                </div>
                <div class="flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p class="font-medium my-4 text-black text-xl leading-relaxed mx-1 ">
                        Ubicación:
                    </p>
                </div>
                <div>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1912.6677131703736!2d-68.12918784562898!3d-16.509155279017744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x915f21b7e47521e1%3A0x7fa0fb5d64caf2f2!2sFUNDACI%C3%93N%20CULTURAL%20DEL%20BANCO%20CENTRAL%20DE%20BOLIVIA!5e0!3m2!1ses-419!2sbo!4v1654261936603!5m2!1ses-419!2sbo" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <!--footer-->
            <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
              <button class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="toggleModal('modal-id-or')">
                Cerrar
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-or-backdrop"></div>

      <script type="text/javascript">
        function toggleModal(modalID){
          document.getElementById(modalID).classList.toggle("hidden");
          document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
          document.getElementById(modalID).classList.toggle("flex");
          document.getElementById(modalID + "-backdrop").classList.toggle("flex");
        }
      </script>
</body>

@endsection
