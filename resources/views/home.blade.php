@extends('layouts.app')


@section('contenido')
    {{-- Seccion de carrousel de ofertas --}}
    <article x-data="slider" class="relative w-full flex flex-shrink-0 overflow-hidden shadow-2xl">
        <div class="rounded-full bg-gray-600 text-white absolute top-5 right-5 text-sm px-2 text-center z-10">
            <span x-text="currentIndex"></span>/
            <span x-text="images.length"></span>
        </div>

        <template x-for="(image, index) in images">
            <figure class="h-[32rem]" x-show="currentIndex == index + 1" x-transition:enter="transition transform duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition transform duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <img :src="image" alt="Image" class="absolute inset-0 z-10 h-full w-full object-cover " />
                {{-- <figcaption class="absolute inset-x-0 bottom-1 z-20 w-96 mx-auto p-4 font-light text-sm text-center tracking-widest leading-snug bg-gray-300 bg-opacity-25">
                    Any kind of content here!
                    Primum in nostrane potestate est, quid meminerimus? Nulla erit controversia. Vestri haec verecundius, illi fortasse constantius.
                </figcaption> --}}
            </figure>
        </template>
        <button @click="back()"
            class="absolute left-14 top-1/2 -translate-y-1/2 w-11 h-11 flex justify-center items-center rounded-full shadow-md z-10 bg-gray-100 hover:bg-gray-200">
            <svg class=" w-8 h-8 font-bold transition duration-500 ease-in-out transform motion-reduce:transform-none text-gray-500 hover:text-gray-600 hover:-translate-x-0.5"
                fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7">
                </path>
            </svg>
        </button>

        <button @click="next()"
            class="absolute right-14 top-1/2 -translate-y-1/2 w-11 h-11 flex justify-center items-center rounded-full shadow-md z-10 bg-gray-100 hover:bg-gray-200">
            <svg class=" w-8 h-8 font-bold transition duration-500 ease-in-out transform motion-reduce:transform-none text-gray-500 hover:text-gray-600 hover:translate-x-0.5"
                fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>


    </article>

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
                    <a href='{{ route('books.show', $book) }}'
                        class="relative block bg-white border border-gray-200 rounded-lg">

                        <img loading="lazy" alt="imagen del post {{ $book->titulo }}"
                            class="object-contain w-full sm:h-72 mt-2 h-56 hover:grow hover:shadow-lg"
                            src="{{ asset('uploads') . '/' . $book->imagen }}" />


                        <div class="p-2">
                            <div class="group cursor-pointer relative ">
                                <p class="line-clamp-2 mt-2 px-2 text-lg font-bold text-dark ">
                                    {{ $book->titulo }}

                                </p>
                                {{-- detalles de Popup de descripcion --}}
                                <div
                                    class="opacity-0 lg:w-60 sm:w-30 lg:ml-20  sm:ml-0d lg:px-1 sm:px-2   bg-black text-white text-center text-sm rounded-lg py-2 absolute z-10 group-hover:opacity-100 bottom-full  pointer-events-none">
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

                            <button onclick="location.href ='{{ route('books.show', $book) }}' " name="add"
                                type="button"
                                class="flex items-center w-full justify-center p-2 sm:px-5 sm:py-3 sm:mt-2 text-white bg-custom-500  hover:bg-orange-400 focus:outline-none  rounded-lg">
                                <span class="text-sm font-medium">
                                    Ver Libro
                                </span>

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
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
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('slider', () => ({
                currentIndex: 1,
                images: [
                    "/img/portada1l.jpeg",
                    "/img/por2.jpg",
                    "/img/por1.jpg",
                ],
                back() {
                    if (this.currentIndex > 1) {
                        this.currentIndex = this.currentIndex - 1;
                    }
                },
                next() {
                    if (this.currentIndex < this.images.length) {
                        this.currentIndex = this.currentIndex + 1;
                    } else if (this.currentIndex <= this.images.length) {
                        this.currentIndex = this.images.length - this.currentIndex + 1
                    }
                },
            }))
        })
    </script>
@endsection
