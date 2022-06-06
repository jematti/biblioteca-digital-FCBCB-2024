@extends('layouts.app')


@section('contenido')

{{-- Seccion de carrousel de ofertas --}}
    <div class="carousel relative container mx-auto" style="max-width:1600px;">
        <div class="carousel-inner relative overflow-hidden w-full">
            <!--Slide 1-->
            <input class="carousel-open" type="radio" id="carousel-1" name="carousel" aria-hidden="true" hidden="" checked="checked">
            <div class="carousel-item absolute opacity-0" style="height:50vh;">
                <div class="block h-full w-full mx-auto pt-6 md:pt-0 md:items-center bg-cover bg-right" style="background-image: url('{{ asset('img/bn1.jpeg')}}');">

                    <div class="container mx-auto">
                        <div class="flex flex-col w-full lg:w-1/2 md:ml-16 items-center md:items-start px-6 tracking-wide">
                            <p class="text-black text-2xl my-4">Libros en Tendencia</p>
                            <a class="text-xl inline-block no-underline border-b border-gray-600 leading-relaxed hover:text-black hover:border-black" href="#">view product</a>
                        </div>
                    </div>

                </div>
            </div>
            <label for="carousel-3" class="prev control-1 w-10 h-10 ml-2 md:ml-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900 leading-tight text-center z-10 inset-y-0 left-0 my-auto">‹</label>
            <label for="carousel-2" class="next control-1 w-10 h-10 mr-2 md:mr-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900 leading-tight text-center z-10 inset-y-0 right-0 my-auto">›</label>

            <!--Slide 2-->
            <input class="carousel-open" type="radio" id="carousel-2" name="carousel" aria-hidden="true" hidden="">
            <div class="carousel-item absolute opacity-0 bg-cover bg-right" style="height:50vh;">
                <div class="block h-full w-full mx-auto  pt-6 md:pt-0 md:items-center bg-cover bg-right" style="background-image: url('{{ asset('img/bn2.jpeg')}}');">

                    <div class="container mx-auto">
                        <div class="flex flex-col w-full lg:w-1/2 md:ml-16 items-center md:items-start px-6 tracking-wide">
                            <p class="text-black text-2xl my-4">Libros por temporada</p>
                            <a class="text-xl inline-block no-underline border-b border-gray-600 leading-relaxed hover:text-black hover:border-black" href="#">view product</a>
                        </div>
                    </div>

                </div>
            </div>
            <label for="carousel-1" class="prev control-2 w-10 h-10 ml-2 md:ml-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900  leading-tight text-center z-10 inset-y-0 left-0 my-auto">‹</label>
            <label for="carousel-3" class="next control-2 w-10 h-10 mr-2 md:mr-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900  leading-tight text-center z-10 inset-y-0 right-0 my-auto">›</label>

            <!--Slide 3-->
            <input class="carousel-open" type="radio" id="carousel-3" name="carousel" aria-hidden="true" hidden="">
            <div class="carousel-item absolute opacity-0" style="height:50vh;">
                <div class="block h-full w-full mx-auto pt-6 md:pt-0 md:items-center bg-cover bg-bottom" style="background-image: url('{{ asset('img/b3.jpg')}}');">

                    <div class="container mx-auto">
                        <div class="flex flex-col w-full lg:w-1/2 md:ml-16 items-center md:items-start px-6 tracking-wide">
                            <p class="text-black text-2xl my-4">Eventos Semanal</p>
                            <a class="text-xl inline-block no-underline border-b border-gray-600 leading-relaxed hover:text-black hover:border-black" href="#">view product</a>
                        </div>
                    </div>

                </div>
            </div>
            <label for="carousel-2" class="prev control-3 w-10 h-10 ml-2 md:ml-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900  leading-tight text-center z-10 inset-y-0 left-0 my-auto">‹</label>
            <label for="carousel-1" class="next control-3 w-10 h-10 mr-2 md:mr-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900  leading-tight text-center z-10 inset-y-0 right-0 my-auto">›</label>

            <!-- Add additional indicators for each slide-->
            <ol class="carousel-indicators">
                <li class="inline-block mr-3">
                    <label for="carousel-1" class="carousel-bullet cursor-pointer block text-4xl text-gray-400 hover:text-gray-900">•</label>
                </li>
                <li class="inline-block mr-3">
                    <label for="carousel-2" class="carousel-bullet cursor-pointer block text-4xl text-gray-400 hover:text-gray-900">•</label>
                </li>
                <li class="inline-block mr-3">
                    <label for="carousel-3" class="carousel-bullet cursor-pointer block text-4xl text-gray-400 hover:text-gray-900">•</label>
                </li>
            </ol>

        </div>
    </div>

    {{-- Seccion de ofertas de libros pagina principal --}}
    <section class="bg-white py-8">

        <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">

            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col" >
                <a href="#">

                    <img class="hover:grow hover:shadow-lg" src="{{ asset('img/PA1.png')}}">

                    <div class="group cursor-pointer relative  pt-3 w-full items-center justify-between">
                        <p class="truncate mt-2 text-xl font-medium text-dark ">
                            Piedra de agua Nro 1
                        </p>
                        <p class="truncate text-left">Revista Nacional Piedra de Agua</p>
                        <div class="opacity-0 w-50 bg-black text-white text-center text-sm rounded-lg py-4 absolute z-10 group-hover:opacity-100 bottom-full -left-1/4 ml-20 px-3 pointer-events-none">
                            Primera edición boliviana de la
                            Historia de la Villa
                            Imperial de Potosí
                            Carta inédita de
                            Gunnar Mendoza
                        </div>

                        {{-- <svg class="h-6 w-6 fill-current text-gray-500 hover:text-black"  viewBox="0 0 24 24">
                            <path d="M12,4.595c-1.104-1.006-2.512-1.558-3.996-1.558c-1.578,0-3.072,0.623-4.213,1.758c-2.353,2.363-2.352,6.059,0.002,8.412 l7.332,7.332c0.17,0.299,0.498,0.492,0.875,0.492c0.322,0,0.609-0.163,0.792-0.409l7.415-7.415 c2.354-2.354,2.354-6.049-0.002-8.416c-1.137-1.131-2.631-1.754-4.209-1.754C14.513,3.037,13.104,3.589,12,4.595z M18.791,6.205 c1.563,1.571,1.564,4.025,0.002,5.588L12,18.586l-6.793-6.793C3.645,10.23,3.646,7.776,5.205,6.209 c0.76-0.756,1.754-1.172,2.799-1.172s2.035,0.416,2.789,1.17l0.5,0.5c0.391,0.391,1.023,0.391,1.414,0l0.5-0.5 C14.719,4.698,17.281,4.702,18.791,6.205z" />
                        </svg>--}}

                    </div>
                     <div class="flex justify-between items-center">
                        <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                     </div>

                     <button  onclick="location.href ='/libro1'" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                        <span class="mx-1">Ver Libro</span>
                     </button>


                    {{-- <button class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-700 focus:outline-none focus:bg-red-700">
                        <svg class="w-5 h-5 mx-1" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                        </svg>
                        <span class="mx-1">Añadir Compra</span>
                    </button> --}}
                </a>
            </div>

            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" src="{{ asset('img/PA2.png')}}">
                    <div class="pt-3  items-center justify-between">
                        <p class="truncate mt-2 text-xl font-medium text-dark "> Piedra de agua Nro 2</p>
                        <p class="truncate text-left">Revista Nacional Piedra de Agua</p>

                    </div>


                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                        </div>
                        <button  onclick="location.href = '/libro2'" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                            <span class="mx-1">Ver Libro</span>
                        </button>


                </a>
            </div>


            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" src="{{ asset('img/PA3.png')}}">
                    <div class="pt-3  items-center justify-between">
                        <p class="truncate mt-2 text-xl font-medium text-dark ">Piedra de agua Nro 3</p>
                        <p class="truncate text-left">Revista Nacional Piedra de Agua</p>
                    </div>

                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                        </div>
                        <button  onclick="location.href = '/libro3'" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                            <span class="mx-1">Ver Libro</span>
                        </button>


                </a>
            </div>

            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" src="{{ asset('img/PA4.png')}}">
                    <div class="pt-3  items-center justify-between">
                        <p class=" truncate mt-2 text-xl font-medium text-dark ">Piedra de agua Nro 4</p>
                        <p class="truncate text-left ">Revista Nacional Piedra de Agua</p>
                    </div>

                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                        </div>
                        <button  onclick="location.href = '/libro4'" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                            <span class="mx-1">Ver Libro</span>
                        </button>


                </a>
            </div>

            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" src="{{ asset('img/PA5.png')}}">
                    <div class="pt-3  items-center justify-between">
                        <p class="truncate mt-2 text-xl font-medium text-dark ">Piedra de agua Nro 5</p>
                        <p class="truncate text-left">Revista Nacional Piedra de Agua</p>
                    </div>


                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                        </div>
                        <button  onclick="location.href = '/libro5'" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                            <span class="mx-1">Ver Libro</span>
                        </button>


                </a>
            </div>

            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" src="{{ asset('img/PA6.png')}}">
                    <div class="pt-3  items-center justify-between">
                        <p class="truncate mt-2 text-xl font-medium text-dark ">
                            Piedra de agua Nro 6</p>
                        <p class="truncate text-left">Revista Nacional Piedra de Agua</p>
                    </div>

                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                        </div>
                        <button  onclick="location.href = '/libro6'" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                            <span class="mx-1">Ver Libro</span>
                        </button>


                </a>
            </div>

            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" src="{{ asset('img/PA7.png')}}">
                    <div class="pt-3  items-center justify-between">
                        <p class="truncate mt-2 text-xl font-medium text-dark ">Piedra de agua Nro 7</p>
                        <p class="truncate text-left">Revista Nacional Piedra de Agua</p>
                    </div>

                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                        </div>
                        <button  onclick="location.href = '/libro7'" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                            <span class="mx-1">Ver Libro</span>
                        </button>

                </a>
            </div>


            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" src="{{ asset('img/PA8.png')}}">
                    <div class="pt-3  items-center justify-between">
                        <p class="truncate mt-2 text-xl font-medium text-dark ">Piedra de agua Nro 8</p>
                        <p class="truncate text-left">Revista Nacional Piedra de Agua</p>
                    </div>

                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                        </div>
                        <button  onclick="location.href = '/libro8'" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                            <span class="mx-1">Ver Libro</span>
                        </button>

                </a>
            </div>

            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" src="{{ asset('img/PA9.png')}}">
                    <div class="pt-3  items-center justify-between">
                        <p class="mt-2 text-xl font-medium text-dark ">Piedra de agua Nro 9</p>
                        <p class="truncate text-left">Revista Nacional Piedra de Agua</p>
                    </div>

                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                        </div>
                        <button  onclick="location.href = '/libro9'" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                            <span class="mx-1">Ver Libro</span>
                        </button>

                </a>
            </div>

            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" src="{{ asset('img/PA10.png')}}">
                    <div class="pt-3  items-center justify-between">
                        <p class=" truncate mt-2 text-xl font-medium text-dark ">Piedra de agua Nro 10</p>
                        <p class="truncate text-left">Revista Nacional Piedra de Agua</p>
                    </div>

                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                        </div>
                        <button  onclick="location.href = '/libro10'" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                            <span class="mx-1">Ver Libro</span>
                        </button>

                </a>
            </div>


            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" src="{{ asset('img/PA11.png')}}">
                    <div class="pt-3  items-center justify-between">
                        <p class="truncate mt-2 text-xl font-medium text-dark ">Piedra de agua Nro 11</p>
                        <p class="truncate text-left">Revista Nacional Piedra de Agua</p>
                    </div>

                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                        </div>
                        <button  onclick="location.href = '/libro11'" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                            <span class="mx-1">Ver Libro</span>
                        </button>

                </a>
            </div>

            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" src="{{ asset('img/PA12.png')}}">
                    <div class="pt-3  items-center justify-between">
                        <p class="truncate mt-2 text-xl font-medium text-dark ">Piedra de agua Nro 12</p>
                        <p class="truncate text-left">Revista Nacional Piedra de Agua</p>
                    </div>

                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                        </div>
                        <button  onclick="location.href = '/libro12'" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                            <span class="mx-1">Ver Libro</span>
                        </button>
                </a>
            </div>

            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" src="{{ asset('img/PA13.png')}}">
                    <div class="pt-3  items-center justify-between">
                        <p class="truncate mt-2 text-xl font-medium text-dark ">Piedra de agua Nro 13</p>
                        <p class="truncate text-left">Revista Nacional Piedra de Agua</p>
                    </div>

                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                        </div>
                        <button  onclick="location.href = '/libro13'" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                            <span class="mx-1">Ver Libro</span>
                        </button>

                </a>
            </div>

            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" src="{{ asset('img/PA14.png')}}">
                    <div class="pt-3  items-center justify-between">
                        <p class="mt-2 text-xl font-medium text-dark truncate ">
                            Piedra de agua Nro 14</p>
                        <p class="truncate text-left">Revista Nacional Piedra de Agua</p>
                    </div>

                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                        </div>
                        <button  onclick="location.href = '/libro14'" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                            <span class="mx-1">Ver Libro</span>
                        </button>

                </a>
            </div>

            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" src="{{ asset('img/PA15.png')}}">
                    <div class="pt-3  items-center justify-between">
                        <p class="truncate mt-2 text-xl font-medium text-dark ">Piedra de agua Nro 15</p>
                        <p class="truncate text-left">Revista Nacional Piedra de Agua</p>
                    </div>

                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                        </div>
                        <button  onclick="location.href = '/libro15'" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                            <span class="mx-1">Ver Libro</span>
                        </button>

                </a>
            </div>

            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" src="{{ asset('img/PA16.png')}}">
                    <div class="pt-3  items-center justify-between">
                        <p class="truncate mt-2 text-xl font-medium text-dark ">Piedra de agua Nro 16</p>
                        <p class="truncate text-left">Revista Nacional Piedra de Agua</p>
                    </div>

                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                        </div>
                        <button  onclick="location.href = '/libro16'" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                            <span class="mx-1">Ver Libro</span>
                        </button>

                </a>
            </div>

            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" src="{{ asset('img/PA17.png')}}">
                    <div class="pt-3  items-center justify-between">
                        <p class="truncate mt-2 text-xl font-medium text-dark ">Piedra de agua Nro 17</p>
                        <p class="truncate text-left">Revista Nacional Piedra de Agua</p>
                    </div>

                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                        </div>
                        <button  onclick="location.href = '/libro17'" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                            <span class="mx-1">Ver Libro</span>
                        </button>

                </a>
            </div>

            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" src="{{ asset('img/PA18.png')}}">
                    <div class="pt-3  items-center justify-between">
                        <p class="truncate mt-2 text-xl font-medium text-dark ">Piedra de agua Nro 18</p>
                        <p class="truncate text-left">Revista Nacional Piedra de Agua</p>
                    </div>

                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                        </div>
                        <button  onclick="location.href = '/libro18'" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                            <span class="mx-1">Ver Libro</span>
                        </button>

                </a>
            </div>

        </div>



    </div>


    </section>
@endsection
