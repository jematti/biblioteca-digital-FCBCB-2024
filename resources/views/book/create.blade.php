@extends('ui.adminnav')

@section('contenido-admin')


<h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Agregar Libro</h2>

    <form action="{{ route('book.store') }}" method="POST" class="w-full max-w-lg" novalidate>
        @csrf
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
              <label class="mb-2 block uppercase text-gray-500 font-bold" >
                Título
              </label>
              <input
                    class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="titulo"
                    name="titulo"
                    type="text"
                    placeholder="Título"
                    @error('titulo')
                    border-red-500
                    @enderror
                    value="{{old('titulo')}}"
                />

                @error('titulo')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
              <label class="mb-2 block uppercase text-gray-500 font-bold" >
                Categoría:
              </label>

              <select
                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                id="grid-state"
                name="categoria"
              >
                <option disabled selected>- Seleccione una categoría -</option>
              {{$title}}
                {{-- @foreach ($category as $categories)
                    <option
                        {{ old('categoria') == $category->id ? 'selected' : '' }}
                        value="{{ $category->id }}"
                    >
                        {{$category->nombre_categoria}}
                    </option>
                @endforeach --}}

              </select>

                @error('categoria')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <select
                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="grid-state"
                    name="idioma"

                >
                        <option value="">- Seleccione el idioma del Libro- </option>
                        <option>Español</option>
                        <option>Aymara</option>
                        <option>Quechua</option>
                        <option>Inglés</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                @error('idioma')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
              <label class="block mb-2 uppercase text-gray-500 font-bold" for="grid-city">
                Páginas
              </label>
              <input
                class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                id="numero_paginas"
                type="number"
                name="numero_paginas"
                placeholder="Nro de Páginas"
                @error('numero_paginas')
                    border-red-500
                @enderror
                value="{{old('nuemro_paginas')}}"
               >

               @error('numero_paginas')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
               @enderror
            </div>
            <div class="w-full md:w-1/2 px-3">
                <label class="block mb-2 uppercase text-gray-500 font-bold" for="grid-city">
                  Edición
                </label>
                <input
                  class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="edicion"
                  name="edicion"
                  type="text"
                  placeholder="Ej: Primera Edición"
                  @error('edicion')
                  border-red-500
                  @enderror
                  value="{{old('edicion')}}"
                 >
                 @error('edicion')
                 <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
              <label class="mb-2 block uppercase text-gray-500 font-bold" >
                Fecha de Publicación
              </label>
              <input
                    class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="fecha_publicacion"
                    name="fecha_publicacion"
                    type="date"
                    placeholder="fecha de publicación del Libro"
                    @error('fecha_publicacion')
                    border-red-500
                    @enderror
                    value="{{old('fecha_publicacion')}}"
                />

                @error('fecha_publicacion')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                @enderror
            </div>
        </div>






        <input
            type="submit"
            value="Actualizar Datos"
            class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3 mt-5"
        />

        </div>
    </form>


@endsection
