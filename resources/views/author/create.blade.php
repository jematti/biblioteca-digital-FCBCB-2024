@extends('ui.adminnav')

@section('contenido-admin')

    <h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Autor</h2>

    {{-- menu de navegacion para crear y editar categorias --}}
    <div class="flex">
        <div class="w-1/2 mt-5 p-2 ">
            <button class="w-full uppercase h-10 px-5 bg-white text-red-500 transition-colors font-bold duration-150 border border-red-500  focus:shadow-outline hover:bg-red-500 hover:text-white py-2  rounded-lg inline-flex " onclick="location.href = '{{ route('author.create') }}'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                  </svg>
                  <span>Agregar Autor</span>
            </button>
        </div>
        <div class="w-1/2  mt-5 p-2 ">
            <button class="w-full uppercase h-10 px-5 bg-white text-red-500 transition-colors font-bold duration-150 border border-red-500  focus:shadow-outline hover:bg-red-500 hover:text-white py-2  rounded-lg inline-flex " onclick="location.href = '{{ route('author.index') }}'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                  </svg>
                  <span>Listar Autores</span>
            </button>
        </div>
   </div>


   {{-- formulario para agregar categoria --}}
    <form action="{{ route('author.store') }}" method="POST" novalidate>

        @csrf
        <div class="mb-5">
            <label for="nombre_autor" class="mb-2 block uppercase text-gray-500 font-bold">
                Nombre de Autor
            </label>
            <input
                id="nombre_autor"
                type="text"
                name="nombre_autor"
                placeholder="Ingrese el nombre de la categoria"
                class="border p-3 w-full rounded-lg"
                @error('nombre_autor')
                    border-red-500
                @enderror
                value="{{old('nombre_autor')}}"
            />
            @error('nombre_autor')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
            @enderror

            <label for="biografia" class="mb-2 block uppercase text-gray-500 font-bold">
                Biografía
            </label>
            <input
                id="biografia"
                type="text"
                name="biografia"
                placeholder="Escribir breve biografía del Autor"
                class="border p-3 w-full rounded-lg"
                @error('biografia')
                    border-red-500
                @enderror
                value="{{old('biografia')}}"
            />
            @error('biografia')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
            @enderror

            <input
                type="submit"
                value="Añadir Autor"
                class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3 mt-5"
            />

    </form>


@endsection
