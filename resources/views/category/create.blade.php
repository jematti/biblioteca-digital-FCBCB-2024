@extends('ui.adminnav')

@section('contenido-admin')

    <h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Categoría</h2>

    {{-- menu de navegacion para crear y editar categorias --}}
    <div class="flex">
        <div class="w-1/2 mt-5 p-2 ">
            <button class="w-full uppercase h-10 px-5 bg-white text-red-500 transition-colors font-bold duration-150 border border-red-500  focus:shadow-outline hover:bg-red-500 hover:text-white py-2  rounded-lg inline-flex " onclick="location.href = '{{ route('category.create') }}'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                  </svg>
                  <span>Agregar Categoría</span>
            </button>
        </div>
        <div class="w-1/2  mt-5 p-2 ">
            <button class="w-full uppercase h-10 px-5 bg-white text-red-500 transition-colors font-bold duration-150 border border-red-500  focus:shadow-outline hover:bg-red-500 hover:text-white py-2  rounded-lg inline-flex " onclick="location.href = '{{ route('category.index') }}'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                  </svg>
                  <span>Listar Categorias</span>
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

            <label for="descripcion" class="mb-2 block uppercase text-gray-500 font-bold">
                Descripción de Categoría (Opcional)
            </label>
            <input
                id="descripcion"
                type="text"
                name="descripcion"
                placeholder="Escribir descripción de la categoria"
                class="border p-3 w-full rounded-lg"
                @error('descripcion')
                    border-red-500
                @enderror
                value="{{old('descripcion')}}"
            />
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
