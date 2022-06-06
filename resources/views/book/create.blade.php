@extends('ui.adminnav')

@section('contenido-admin')

<h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Agregar Libro</h2>
<form action="#" method="POST" novalidate>


    @csrf
    <div class="mb-5">
        <label for="titulo" class="mb-2 block uppercase text-gray-500 font-bold">
            Título
        </label>
        <input
            id="titulo"
            type="text"
            name="titulo"
            placeholder="Ingrese titulo del libro"
            class="border p-3 w-full rounded-lg"
            @error('titulo')
                border-red-500
            @enderror
            value="{{old('titulo')}}"
        />
        @error('titulo')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
        @enderror

        <label for="edicion" class="mb-2 block uppercase text-gray-500 font-bold">
            Edición
        </label>
        <input
            id="edicion"
            type="text"
            name="edicion"
            placeholder="numero de edicion"
            class="border p-3 w-full rounded-lg"
            @error('edicion')
                border-red-500
            @enderror
            value="{{old('edicion')}}"
        />
        @error('edicion')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
        @enderror

        <label for="ubicacion" class="mb-2 block uppercase text-gray-500 font-bold">
            Ubicación Fisica del libro
        </label>
        <input
            id="ubicacion"
            type="text"
            name="ubicacion"
            placeholder="Indicar donde sucursal donde se encuentra el libro"
            class="border p-3 w-full rounded-lg"
            @error('ubicacion')
                border-red-500
            @enderror
            value="{{old('ubicacion')}}"
        />
        @error('ubicacion')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
        @enderror

        <label for="num_pag" class="mb-2 block uppercase text-gray-500 font-bold">
            Número de Páginas
        </label>
        <input
            id="num_pag"
            type="text"
            name="num_pag"
            placeholder="Ingrese el número de páginas del libro"
            class="border p-3 w-full rounded-lg"
            @error('num_pag')
                border-red-500
            @enderror
            value="{{old('num_pag')}}"
        />
        @error('num_pag')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
        @enderror

        <label for="num_pag" class="mb-2 block uppercase text-gray-500 font-bold">
            Fecha de Publicación
        </label>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
            </div>
            <input datepicker type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
        </div>


        <label for="idioma" class="mb-2 block uppercase text-gray-500 font-bold">
            Idioma
        </label>
        <input
            id="idioma"
            type="text"
            name="idioma"
            placeholder="Idiom del libro"
            class="border p-3 w-full rounded-lg"
            @error('idioma')
                border-red-500
            @enderror
            value="{{old('idioma')}}"
        />
        @error('idioma')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
        @enderror

        <label for="resumen" class="mb-2 block uppercase text-gray-500 font-bold">
            Resumen
        </label>
        <input
            id="resumen"
            type="text"
            name="resumen"
            placeholder="Resumen del libro"
            class="border p-3 w-full rounded-lg"
            @error('resumen')
                border-red-500
            @enderror
            value="{{old('resumen')}}"
        />
        @error('resumen')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
        @enderror

        <div class="mb-5">
            <label
                for="descripcion"
                class="block text-gray-700 text-sm mb-2"
            >Imagen del libro:</label>

            <div id="dropzoneDevJobs" class="dropzone rounded bg-gray-100"></div>

            <input type="hidden" name="imagen" id="imagen" value="{{ old('imagen') }}" >
            @error('imagen')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3 mb-6" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block"> {{$message}}</span>
                </div>
            @enderror
            <p id="error"></p>
        </div>

        <input
            type="submit"
            value="Actualizar Datos"
            class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3 mt-5"
        />

    </div>
</form>


@endsection
