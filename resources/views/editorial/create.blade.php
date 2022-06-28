@extends('ui.nav')

@section('contenido-admin')

    <h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Editorial</h2>

    {{-- menu de navegacion para crear y editar editorial --}}
    <div class="flex">
        <div class="w-1/2 mt-5 p-2 ">
            <button class="w-full uppercase h-10 px-5 bg-white text-red-500 transition-colors font-bold duration-150 border border-red-500  focus:shadow-outline hover:bg-red-500 hover:text-white py-2  rounded-lg inline-flex " onclick="location.href = '{{ route('editorial.create') }}'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                  </svg>
                  <span>Agregar Editorial</span>
            </button>
        </div>
        <div class="w-1/2  mt-5 p-2 ">
            <button class="w-full uppercase h-10 px-5 bg-white text-red-500 transition-colors font-bold duration-150 border border-red-500  focus:shadow-outline hover:bg-red-500 hover:text-white py-2  rounded-lg inline-flex " onclick="location.href = '{{ route('editorial.index') }}'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                  </svg>
                  <span>Listar Editoriales</span>
            </button>
        </div>
   </div>



   {{-- formulario para agregar editorial --}}
    <form action="{{ route('editorial.store') }}" method="POST" novalidate>

        @csrf
        <div class="mb-5">
            <label for="nombre_editorial" class="mb-2 block uppercase text-gray-500 font-bold">
                Nombre de la Editorial
            </label>
            <input
                id="nombre_editorial"
                type="text"
                name="nombre_editorial"
                placeholder="Ingrese el nombre de la editorial"
                class="border p-3 w-full rounded-lg"
                @error('nombre_editorial')
                    border-red-500
                @enderror
                value="{{old('nombre_editorial')}}"
            />
            @error('nombre_editorial')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
            @enderror

            <label for="direccion" class="mb-2 block uppercase text-gray-500 font-bold">
                Dirección de la Editorial
            </label>
            <input
                id="direccion"
                type="text"
                name="direccion"
                placeholder="Escribir dirección de la editorial"
                class="border p-3 w-full rounded-lg"
                @error('direccion')
                    border-red-500
                @enderror
                value="{{old('direccion')}}"
            />
            @error('direccion')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
            @enderror

            <label for="contacto" class="mb-2 block uppercase text-gray-500 font-bold">
                Contactos de la Editorial
            </label>
            <input
                id="direccion"
                type="text"
                name="contacto"
                placeholder="Escribir contacto de la editorial (telefono, email, etc)"
                class="border p-3 w-full rounded-lg"
                @error('contacto')
                    border-red-500
                @enderror
                value="{{old('contacto')}}"
            />
            @error('contacto')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
            @enderror

            <input
                type="submit"
                value="Añadir Editorial"
                class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3 mt-5"
            />

    </form>


@endsection
