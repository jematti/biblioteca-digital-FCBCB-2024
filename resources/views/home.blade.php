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

    <section class="py-2">
        {{-- mostrar catalogo de productos --}}
        <div class="max-w-screen-xl px-2 py-2 mx-auto sm:px-6 my-5 bg-white border border-gray-200 rounded-lg">
            <div class="flex flex-wrap items-center">
                <p class="font-bold pr-5 text-xl my-2">
                    CATALOGO DE LIBROS
                </p>
                <p class="font-semibold text-lg  my-2">
                    <a href="{{route('filter.index')}}" class="text-orange-500 hover:text-orange-400 underline"> Ver más</a>
                </p>
            </div>
            {{-- listado productos--}}
            <div class="grid grid-cols-2 gap-3 mt-4 sm:grid-cols-2 lg:grid-cols-5 ">

                {{-- seccion de libros --}}
                @foreach ($products as $product)
                        <a href='{{ route('products.show', $product) }}'
                            class="block bg-white border border-gray-200 rounded-lg">

                            <img loading="lazy" alt="imagen del post {{ $product->titulo }}"
                                class="object-contain w-full sm:h-72 mt-2 h-56 hover:grow hover:shadow-lg"
                                src="{{ asset('uploads') . '/' . $product->imagen }}" />


                            <div class="p-2">
                                <div class="group cursor-pointer relative ">
                                    <p class="line-clamp-2 mt-2 px-2 text-md font-bold text-dark ">
                                        {{ $product->titulo }}

                                    </p>
                                    {{-- detalles de Popup de descripcion --}}
                                    <div
                                        class="opacity-0 lg:w-60 sm:w-30 lg:ml-20  sm:ml-0d lg:px-1 sm:px-2   bg-black text-white text-center text-sm rounded-lg py-2 absolute z-10 group-hover:opacity-100 bottom-full  pointer-events-none">
                                        {{ $product->titulo }}
                                        <br>
                                        {{ $product->author->nombre_autor }}
                                    </div>
                                    {{-- fin de detalle --}}
                                </div>

                                <h5 class="truncate px-2 text-base font-medium text-gray-500">
                                    {{ $product->author->nombre_autor }}
                                </h5>


                                <p class="mt-2 text-lg font-semibold px-2 ">
                                    Bs. {{ $product->precio }}
                                </p>

                                <button onclick="location.href ='{{ route('products.show', $product) }}' " name="add"
                                    type="button"
                                    class="flex items-center w-full justify-center p-2 sm:px-5 sm:py-3 sm:mt-2 text-white bg-custom-500  hover:bg-orange-400 focus:outline-none  rounded-lg">
                                    <span class="text-sm font-medium">
                                        Ver Descripción
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
            {{-- fin listado productos--}}

            {{-- paginacion --}}
            <div class="my-10">
                {{ $products->links() }}
            </div>
        </div>
        {{-- fin de catalogo de libros --}}

        {{-- repositorios --}}
        <div class="max-w-screen-xl px-2 py-2 mx-auto sm:px-6 bg-white border border-gray-200 rounded-lg">
            <div class="md:grid flex flex-wrap gap-3 mt-4 md:grid-cols-2 lg:grid-cols-3">

                {{-- seccion de libros --}}
                @foreach ($repositories as $repository)
                        <a href='{{ route('repository.show', $repository) }}'
                            class="relative block bg-white border border-gray-200 rounded-lg mx-auto mt-2">

                            <img loading="lazy" alt="imagen del repositorio"
                                class="w-52 md:object-contain mx-auto md:w-full sm:h-72 mt-2 h-56 hover:grow hover:shadow-lg"
                                src="{{ asset('img/repositorio') . '/' . $repository->imagen_repositorio }}"  />

                            <div class="p-2">
                                <div class="group cursor-pointer relative ">
                                    <p class="max-w-fit mx-auto mt-2 px-2 text-center text-sm md:text-lg font-bold text-dark ">
                                        {{ $repository->nombre_repositorio }}
                                    </p>
                                </div>

                                <h5 class="truncate px-2 text-base text-center font-medium text-gray-500">
                                    ({{ $repository->sigla }})
                                </h5>

                                <button onclick="location.href ='{{ route('repository.show', $repository) }}' " name="add"
                                    type="button"
                                    class="flex items-center w-full justify-center p-2 sm:px-5 sm:py-3 sm:mt-2 text-white bg-custom-500  hover:bg-orange-400 focus:outline-none  rounded-lg">
                                    <span class="text-lg font-medium">
                                        Ver Repositorio
                                    </span>

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" />
                                    </svg>
                                </button>
                            </div>
                        </a>

                @endforeach
                {{-- fin de seccion libros --}}
            </div>
        </div>
        {{-- fin repositorios --}}

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
