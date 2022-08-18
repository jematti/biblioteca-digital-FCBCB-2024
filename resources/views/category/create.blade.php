@extends('ui.nav')

@section('contenido-admin')

    <h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Categoría</h2>


    {{-- menu de navegacion para crear y editar categorias --}}
    <div class="md:grid grid-cols-2 gap-1  sm:flex-grow">
        <div class="my-2 p-2 ">
            <button class="w-full p-2 uppercase bg-sky-600 text-white font-bold hover:bg-sky-700 border border-gray-900  rounded-lg" onclick="location.href = '{{ route('category.create') }}'">
                <i class="fa-solid fa-plus"></i><span class="px-2">Agregar Categoria</span>
            </button>
        </div>
        <div class="my-2 p-2 ">
            <button class="w-full p-2 uppercase bg-sky-600 text-white font-bold hover:bg-sky-700 border border-gray-900  rounded-lg" onclick="location.href = '{{ route('category.index') }}'">
                <i class="fa-solid fa-angle-down"></i><span class="px-2">Listar Categorias</span>
            </button>
        </div>
   </div>


   {{-- formulario para agregar categoria --}}

    <form action="{{ route('category.store') }}" method="POST" novalidate>

        @csrf
        <div class="mb-5">
            <label for="nombre_categoria" class="mb-2 block uppercase text-gray-500 font-bold">
                Nombre de Categoría
            </label>

            <input
                id="nombre_categoria"
                type="text"
                name="nombre_categoria"
                placeholder="Ingrese el nombre de la categoria"
                class="border p-3 w-full rounded-lg"
                @error('nombre_categoria')
                    border-red-500
                @enderror
                value="{{old('nombre_categoria')}}"
            />
            @error('nombre_categoria')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
            @enderror

            <label class="mb-2 block uppercase text-gray-500 font-bold" >
                Descripción
              </label>
                <textarea
                class="
                    form-control
                    block
                    w-full
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-gray-700
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    m-0
                    focus:text-neutral-700 focus:bg-white focus:border-gray-600 focus:outline-none
                "
                id="descripcion"
                name="descripcion"
                placeholder="Descripción de la Categoría"
                @error('descripcion')
                border-red-500
                @enderror
                value="{{old('descripcion')}}"
                rows="3"
                ></textarea>

                @error('descripcion')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                @enderror

            <input
                type="submit"
                value="Añadir Categoría"
                class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3 mt-5"
            />

    </form>


@endsection
