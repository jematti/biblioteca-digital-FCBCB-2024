@extends('layouts.app')


@section('contenido')

{{-- Seccion de carrousel de ofertas --}}
<div class="carousel static">
    {{-- <div class="carousel static container mx-auto" style="max-width:1600px;"> --}}
    <div class="carousel-inner relative overflow-hidden w-full">
        <!--Slide 1-->
        <input class="carousel-open" type="radio" id="carousel-1" name="carousel" aria-hidden="true" hidden="" checked="checked">
        <div class="carousel-item absolute opacity-0" style="height:50vh;">
            <div class="block h-full w-full mx-auto pt-6 md:pt-0 md:items-center bg-cover bg-right" style="background-image: url('{{ asset('img/portada1l.jpeg')}}');">

                {{-- <div class="container mx-auto">
                        <div class="flex flex-col w-full lg:w-1/2 md:ml-16 items-center md:items-start px-6 tracking-wide">
                            <p class="text-black text-2xl my-4">Libros en Tendencia</p>
                            <a class="text-xl inline-block no-underline border-b border-gray-600 leading-relaxed hover:text-black hover:border-black" href="#">view product</a>
                        </div>
                    </div> --}}

            </div>
        </div>
        <label for="carousel-3" class="prev control-1 w-10 h-10 ml-2 md:ml-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900 leading-tight text-center z-10 inset-y-0 left-0 my-auto">‹</label>
        <label for="carousel-2" class="next control-1 w-10 h-10 mr-2 md:mr-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900 leading-tight text-center z-10 inset-y-0 right-0 my-auto">›</label>

        <!--Slide 2-->
        <input class="carousel-open" type="radio" id="carousel-2" name="carousel" aria-hidden="true" hidden="">
        <div class="carousel-item absolute opacity-0 bg-cover bg-right" style="height:50vh;">
            <div class="block h-full w-full mx-auto  pt-6 md:pt-0 md:items-center bg-cover bg-right" style="background-image: url('{{ asset('img/por2.jpg')}}');">

                {{-- <div class="container mx-auto">
                        <div class="flex flex-col w-full lg:w-1/2 md:ml-16 items-center md:items-start px-6 tracking-wide">
                            <p class="text-black text-2xl my-4">Libros por temporada</p>
                            <a class="text-xl inline-block no-underline border-b border-gray-600 leading-relaxed hover:text-black hover:border-black" href="#">view product</a>
                        </div>
                    </div> --}}

            </div>
        </div>
        <label for="carousel-1" class="prev control-2 w-10 h-10 ml-2 md:ml-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900  leading-tight text-center z-10 inset-y-0 left-0 my-auto">‹</label>
        <label for="carousel-3" class="next control-2 w-10 h-10 mr-2 md:mr-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900  leading-tight text-center z-10 inset-y-0 right-0 my-auto">›</label>

        <!--Slide 3-->
        <input class="carousel-open" type="radio" id="carousel-3" name="carousel" aria-hidden="true" hidden="">
        <div class="carousel-item absolute opacity-0" style="height:50vh;">
            <div class="block h-full w-full mx-auto pt-6 md:pt-0 md:items-center bg-cover bg-bottom" style="background-image: url('{{ asset('img/por1.jpg')}}');">

                {{-- <div class="container mx-auto">
                        <div class="flex flex-col w-full lg:w-1/2 md:ml-16 items-center md:items-start px-6 tracking-wide">
                            <p class="text-black text-2xl my-4">Eventos Semanal</p>
                            <a class="text-xl inline-block no-underline border-b border-gray-600 leading-relaxed hover:text-black hover:border-black" href="#">view product</a>
                        </div>
                    </div> --}}

            </div>
        </div>
        <label for="carousel-2" class="prev control-3 w-10 h-10 ml-2 md:ml-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900  leading-tight text-center z-10 inset-y-0 left-0 my-auto">‹</label>
        <label for="carousel-1" class="next control-3 w-10 h-10 mr-2 md:mr-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900  leading-tight text-center z-10 inset-y-0 right-0 my-auto">›</label>

        <!-- Add additional indicators for each slide-->
        <ol class="carousel-indicators">
            <li class="inline-block mr-3">
                <label for="carousel-1" class="carousel-bullet cursor-pointer block text-4xl text-white hover:text-gray-900">•</label>
            </li>
            <li class="inline-block mr-3">
                <label for="carousel-2" class="carousel-bullet cursor-pointer block text-4xl text-white hover:text-gray-900">•</label>
            </li>
            <li class="inline-block mr-3">
                <label for="carousel-3" class="carousel-bullet cursor-pointer block text-4xl text-white hover:text-gray-900">•</label>
            </li>
        </ol>

    </div>
</div>

{{-- mostrar libros de la base de datos --}}

<section class=" py-2">
    <div class="max-w-screen-xl px-2 py-2 mx-auto sm:px-6  ">

        <div class="grid grid-cols-2 gap-3 mt-4 sm:grid-cols-2 lg:grid-cols-5">

            {{-- listar categorias --}}
            {{-- @foreach ($categorias as $categoria)
            <div class="bg-slate-500">
                <p class="font-semibold text-lg text-white">
                    {{ $categoria->nombre_categoria}}
                </p>
            </div>
            @endforeach --}}
            {{-- fin lista de categorias --}}

            {{-- seccion de libros --}}
            @foreach ($books as $book)
            <a href='{{ route('books.show', $book) }}' class="relative block bg-white border border-gray-200 rounded-lg">

                <img loading="lazy" alt="imagen del post {{ $book->titulo }}" class="object-contain w-full sm:h-72 mt-2 h-56 hover:grow hover:shadow-lg" src="{{ asset('uploads').'/'.$book->imagen}}" />


                <div class="p-2">
                    <div class="group cursor-pointer relative ">
                        <p class="line-clamp-2 mt-2 px-2 text-lg font-bold text-dark ">
                            {{ $book->titulo }}

                        </p>
                        {{-- detalles de Popup de descripcion --}}
                        <div class="opacity-0 lg:w-60 sm:w-30 lg:ml-20  sm:ml-0d lg:px-1 sm:px-2   bg-black text-white text-center text-sm rounded-lg py-2 absolute z-10 group-hover:opacity-100 bottom-full  pointer-events-none">
                            {{ $book->titulo }}
                            <br>
                            {{ $book->author->nombre_autor }}
                        </div>
                        {{-- fin de detalle --}}
                    </div>

                    <h5 class="truncate px-2 text-base font-medium text-gray-500">
                        {{ $book->author->nombre_autor }}
                    </h5>


                    <p class="mt-2 text-lg font-semibold px-2 ">
                        Bs. {{ $book->precio }}
                    </p>

                    <button onclick="location.href ='{{ route('books.show', $book) }}' " name="add" type="button" class="flex items-center w-full justify-center p-2 sm:px-5 sm:py-3 sm:mt-2 text-white bg-custom-500  hover:bg-orange-400 focus:outline-none  rounded-lg">
                        <span class="text-sm font-medium">
                            Ver Libro
                        </span>

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>

                    </button>
                </div>
            </a>
            @endforeach
            {{-- fin de seccion libros --}}

        </div>

        {{-- paginacion --}}
        <div class="my-10">
            {{ $books->links() }}
        </div>
    </div>
</section>




{{-- Seccion para el footer --}}
@livewire('footer')

@endsection
