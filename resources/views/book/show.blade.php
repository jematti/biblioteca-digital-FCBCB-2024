
@extends('layouts.app')


@section('contenido')

<main class="max-w-7xl mx-auto bg-white">
    <section class="text-gray-600 body-font overflow-hidden ">
       {{-- seccion descripcion de libro  --}}
      <div class="container px-5 py-24 mx-auto">
        <div class="lg:w-full flex flex-wrap mx-2 object-center">
          {{-- seccion de la imagen --}}
          <img alt="imagen del post {{ $book->titulo }}" class="lg:w-1/4 max-w-screen-sm lg:h-72 h-64 object-cover object-center rounded" src="{{ asset('uploads').'/'.$book->imagen}}">
          {{-- seccion informacion del libro --}}
          <div class="lg:w-2/5 w-full lg:pl-5 lg:py-6 lg:pr-2 mt-6 lg:mt-0 ">
            <h1 class="text-gray-900 text-4xl title-font font-medium mb-1">{{ $book->titulo }}</h1>
            <h2 class="text-xl title-font text-gray-500 tracking-widest">
                <a href="{{ route('author.show', $book->author->id) }}">
                    {{ $book->author->nombre_autor }}
                </a>
            </h2>
              <p
                x-data="{ isCollapsed: false, maxLength: 350, originalContent: '', content: '' }"
                x-init="originalContent = $el.firstElementChild.textContent.trim(); content = originalContent.slice(0, maxLength)"
                >
                    <span x-text="isCollapsed ? originalContent : content">
                        {{ $book->resumen }}
                    </span>
                    ...
                    <button
                    @click="isCollapsed = !isCollapsed"
                    x-show="originalContent.length > maxLength"
                    x-text="isCollapsed ? 'Ver menos' : 'Ver mas'"
                    class="font-semibold text-gray-500 underline"
                    ></button>
                </p>

            <hr class="mb-2">
            <div class="flex">
                <h4 class="font-medium mx-4">Categoria:</h4>
              <button class="flex text-white bg-green-700 border-0 py-2 px-6 focus:outline-none hover:bg-green-600 rounded">{{ $book->category->nombre_categoria }}</button>
            </div>
          </div>
          {{-- seccion de ubicacion del libro --}}
          <div class="lg:w-1/3 w-full lg:pl-2 lg:py-6 mt-6 lg:mt-0 lg:border-l border-gray-900 ">
            <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">Caracteristicas</h1>
                {{-- Tabla de datos del libro --}}

                <div class="block overflow-x-auto pb-4">
                    <table>
                    <tbody>
                        <tr>
                            <td class="align-middle text-lg text-left flex text-blueGray-700 ">
                                <p class="font-bold mr-2">idioma: </p>  {{ $book->idioma }}
                            </td>
                        </tr>
                            <td class="align-middle text-lg text-left flex text-blueGray-700 ">
                                <p class="font-bold mr-2">Fecha de Publicación: </p>  {{ $book->fecha_publicacion }}
                            </td>
                        <tr>
                        </tr>
                    </tbody>

                    </table>
                </div>


                {{-- informacion de envio  --}}
                <div class="bg-blue-100  border-blue-500 text-blue-700 p-4 text-left"  role="alert">

                    <h5 class="text-gray-900 text-xl font-bold mb-2">Disponible en las Sucursales: </h5>

                        <button class="bg-blue-600 text-white mx-5  font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="toggleModal('modal-id-lp')">
                            {{ $book->repository->ciudad}}
                        </button>
                </div>
          </div>
        </div>
      </div>
       {{-- fin de seccion de descrpcion de libro --}}
      <hr>
      {{-- seccion ficha tecnica de libro --}}
      <section class="py-1 bg-blueGray-50">
        <div class="w-full xl:w-8/12 mb-24 xl:mb-0 px-4 mx-auto mt-10">
          <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded ">
            <div class="rounded-t mb-0 px-4 py-3 border-0">
              <div class="flex flex-wrap items-center">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                  <h3 class="font-semibold text-lg text-blueGray-700">Ficha técnica de {{ $book->titulo }}</h3>
                </div>
              </div>
            </div>

            <div class="block w-full overflow-x-auto">
              <table class="items-center bg-transparent w-full border-collapse ">
                <tbody>
                  <tr>
                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4 text-left  ">
                      Titulo :
                    </th>
                    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4 ">
                      {{ $book->titulo }}
                    </td>
                    <th class="border-t-0 px-6 align-center border-l-0 border-r-0 text-base whitespace-nowrap p-4 text-left">
                      Autor :
                    </th>
                    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                       {{ $book->author->nombre_autor }}
                    </td>
                  </tr>
                  <tr>
                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4 text-left ">
                      Nro. de páginas  :
                    </th>
                    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                      {{ $book->numero_paginas }}
                    </td>
                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4 text-left">
                      Editorial :
                    </th>
                    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                     {{ $book->editorial->nombre_editorial }}
                    </td>
                  </tr>
                  <tr>
                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4 text-left ">
                      Fecha Publicación :
                    </th>
                    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4 ">
                      {{ $book->fecha_publicacion }}
                    </td>

                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4 text-left">
                        Idioma :
                      </th>
                      <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                          {{ $book->idioma }}
                    </td>

                  </tr>
                  <tr>

                    @if($book->ancho != '')
                     <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4 text-left ">
                        Ancho :
                      </th>
                      <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                          {{ $book->ancho }} cm
                      </td>
                    @endif

                    @if($book->grueso != '')
                      <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4 text-left">
                        Grueso :
                      </th>
                      <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                          {{ $book->grueso }} cm
                      </td>
                    @endif
                  </tr>
                  <tr>

                    @if($book->peso != '')
                      <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4 text-left">
                        Peso :
                      </th>
                      <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                          {{ $book->peso}} gr
                      </td>
                    @endif


                    @if($book->alto != '')
                      <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4 text-left">
                        Alto :
                      </th>
                      <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                        {{ $book->alto}} cm
                      </td>

                    @endif

                  </tr>
                </tbody>

              </table>
            </div>
          </div>
        </div>
      {{-- fin seccion ficha tecnica --}}
    </section>

    {{-- Codigo Modal de ubicacion del libro--}}
    <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="modal-id-lp">
        <div class="relative w-auto my-6 mx-auto max-w-3xl">
          <!--content modal-->
          <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
            <!--header modal-->
            <div class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
              <h3 class="text-3xl font-semibold">
                Contactanos en la Ciudad de {{ $book->repository->ciudad}}
              </h3>
              <button class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none" onclick="toggleModal('modal-id-lp')">
                <span class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                  ×
                </span>
              </button>
            </div>
            <!--body modal-->
            <div class="flex flex-col p-6">
                <div class="flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-5 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <p class="font-medium my-4 text-black text-xl leading-relaxed mx-1 ">
                            Correo Electronico: {{ $book->repository->correo}}

                    </p>
                </div>
                <div class="flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <p class="font-medium my-4 text-black text-xl leading-relaxed mx-1 ">
                        Celulares/Telefonos: {{ $book->repository->telefono}}
                    </p>
                </div>
                <div class="flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="font-medium my-4 text-black text-xl leading-relaxed mx-1 ">
                        Encargado: {{ $book->repository->nombre_encargado}}
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
                    {!! $book->repository->ubicacion !!}
                </div>
            </div>


            <!--footer del modal-->
            <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
              <button class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="toggleModal('modal-id-lp')">
                Cerrar
              </button>
            </div>
          </div>
        </div>
     </div>
     <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-lp-backdrop"></div>
     {{-- fin modal --}}


      <script type="text/javascript">
        function toggleModal(modalID){
          document.getElementById(modalID).classList.toggle("hidden");
          document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
          document.getElementById(modalID).classList.toggle("flex");
          document.getElementById(modalID + "-backdrop").classList.toggle("flex");
        }
      </script>
</main>
@endsection
