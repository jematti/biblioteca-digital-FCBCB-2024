@extends('layouts.app')


@section('contenido')
<section class="bg-white py-2">
    <div class="max-w-screen-xl px-4 py-4 mx-auto sm:px-6 lg:px-8 ">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-2xl sm:truncate text-center">Resultados de la Busqueda :</h2>
        <div class="grid grid-cols-2 gap-3 mt-4 sm:grid-cols-2 lg:grid-cols-5 ">
            {{-- seccion de libros --}}
            @forelse($books as $book)
                <a
                href='{{ route('books.show', $book) }}'
                class="relative block bg-white border border-gray-200"
                >
                    <img
                        loading="lazy"
                        alt="imagen del post {{ $book->titulo }}"
                        class="object-contain w-full sm:h-72 h-56 hover:grow hover:shadow-lg"
                        src="{{ asset('uploads').'/'.$book->imagen}}"
                    />


                    <div class="p-6">
                        <div class="group cursor-pointer relative ">
                            <p class="truncate mt-2 text-xl font-medium text-dark ">
                                {{ $book->titulo }}

                            </p>
                            {{-- detalles de descripcion --}}
                            <div class="opacity-0 w-60 bg-black text-white text-center text-sm rounded-lg py-4 absolute z-10 group-hover:opacity-100 bottom-full -left-1/4 ml-20 px-3 pointer-events-none">
                                {{ $book->titulo }}
                                <br>
                                {{ $book->author->nombre_autor }}

                            </div>
                        </div>

                        <h5 class="truncate text-lg font-bold">
                            {{ $book->author->nombre_autor }}
                        </h5>


                        <p class="mt-2 text-sm font-medium text-gray-600">
                            {{ $book->precio}}
                        </p>

                        <button
                            onclick="location.href ='{{ route('books.show', $book) }}' "
                            name="add"
                            type="button"
                            class="flex items-center w-full justify-center p-2 sm:px-8 sm:py-4 sm:mt-4 text-white bg-red-500  hover:bg-red-400 focus:outline-none focus:bg-red-400 rounded-sm"
                        >
                        <span class="text-sm font-medium">
                            Ver Libro
                        </span>

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>

                        </button>
                    </div>
                </a>

            @empty
        </div>
              <div class="p-4 rounded-lg shadow-lg flex">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                    <p class="text-lg font-semibold text-gray-700">
                        Ningun Producto coincida con esos parametros
                     </p>
              </div>

            @endforelse
            {{-- fin de seccion libros --}}

    </div>
@endsection
