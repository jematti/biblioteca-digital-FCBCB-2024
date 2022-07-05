@extends('ui.nav')

@section('contenido-admin')

{{-- mostrar estilos de dropzone solo en esta vista --}}
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

<h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Agregar Libro</h2>



    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-1/2  px-3">
            <label class="mb-2 block uppercase text-gray-500 font-bold" >
                Imagen del Libro
              </label>
        <form enctype="multipart/form-data" action="{{ route('imagenes.store') }}" method="POST" id="dropzone" class="dropzone border-dashed border-2 w-full h-96 rounded flex flex-col justify-center items-center" >
            @csrf
        </form>
        </div>
    </div>

    <form action="{{ route('books.store') }}" method="POST" class="w-full " novalidate>
        @csrf
        <div class="mb-5">
            <input
             type="hidden"
             name="imagen"
             id="imagen"
             value="{{ old('imagen') }}"
             >

             @error('imagen')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
             @enderror
        </div>

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
                    placeholder="Título del Libro"
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
            <div class="w-full md:w-1/2 px-3">
              <label class="mb-2 block uppercase text-gray-500 font-bold" >
                  Precio del Libro
              </label>
              <input
                    class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="precio"
                    name="precio"
                    type="text"
                    placeholder="Precio del Libro"
                    @error('precio')
                    border-red-500
                    @enderror
                    value="{{old('precio')}}"
                />

                @error('precio')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                @enderror
            </div>
            <div class="w-full md:w-1/2 px-3">
                <label class="mb-2 block uppercase text-gray-500 font-bold" >
                    Stock (Numero de copias del libro)
                  </label>
                  <input
                        class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="cantidad"
                        name="cantidad"
                        type="text"
                        placeholder="Precio del Libro"
                        @error('cantidad')
                        border-red-500
                        @enderror
                        value="{{old('cantidad')}}"
                    />

                    @error('cantidad')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="mb-2 block uppercase text-gray-500 font-bold" >
                    Ubicación:
                </label>
                <select
                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="ubicacion"
                    name="ubicacion"

                >
                <option disabled selected>- Seleccione una Ubicación -</option>

                @foreach ($repositories as $repository)
                    <option
                        {{ old('ubicacion') == $repository->id ? 'selected' : '' }}
                        value="{{ $repository->id }}"
                    >
                    {{$repository->ciudad}} | {{$repository->nombre_repositorio}}
                    </option>
                @endforeach

                </select>

                @error('ubicacion')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                @enderror
            </div>
        </div>



        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
              <label class="mb-2 block uppercase text-gray-500 font-bold" >
                Autor:
              </label>

              <select
                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                id="author"
                name="author"
              >
                <option disabled selected>- Seleccione una Autor -</option>

                @foreach ($authors as $author)
                    <option
                        {{ old('author') == $author->id ? 'selected' : '' }}
                        value="{{ $author->id }}"
                    >
                        {{$author->nombre_autor}}
                    </option>
                @endforeach

              </select>

                @error('author')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
              <label class="mb-2 block uppercase text-gray-500 font-bold" >
                Editorial:
              </label>

              <select
                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                id="editorial"
                name="editorial"
              >
                <option disabled selected>- Seleccione Editorial-</option>
                @foreach ($editorials as $editorial)
                    <option
                        {{ old('editorial') == $editorial->id ? 'selected' : '' }}
                        value="{{ $editorial->id }}"
                    >
                        {{$editorial->nombre_editorial}}
                    </option>
                @endforeach

              </select>

                @error('editorial')
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
                id="category"
                name="category"
              >
                <option disabled selected>- Seleccione una categoría -</option>

                @foreach ($categories as $category)
                    <option
                        {{ old('category') == $category->id ? 'selected' : '' }}
                        value="{{ $category->id }}"
                    >
                        {{$category->nombre_categoria}}
                    </option>
                @endforeach
              </select>

                @error('category')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="mb-2 block uppercase text-gray-500 font-bold" >
                    Idioma:
                </label>
                <select
                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="idioma"
                    name="idioma"

                >
                        {{ $idioma="" }}
                        <option value="">- Seleccione el idioma del Libro- </option>
                        <option value="español" {{ old('idioma',$idioma)=='español' ? 'selected' : ''  }}>Español</option>
                        <option value="aymara" {{ old('idioma',$idioma)=='aymara' ? 'selected' : ''  }}>Aymara</option>
                        <option value="quechua" {{ old('idioma',$idioma)=='quechua' ? 'selected' : ''  }}>Quechua</option>
                        <option value="ingles" {{ old('idioma',$idioma)=='ingles' ? 'selected' : ''  }}>Ingles</option>

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
                value="{{old('numero_paginas')}}"
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

        {{-- datos opcionales --}}
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block mb-2 uppercase text-gray-500 font-bold" for="grid-city">
                    Ancho (opcional)
                  </label>
                  <input
                    class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="ancho"
                    type="number"
                    name="ancho"
                    placeholder="Ancho del libro en 'cm' (centimetros)"
                    value="{{old('ancho')}}"
                   >
            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                <label class="block mb-2 uppercase text-gray-500 font-bold" for="grid-city">
                    Alto (opcional)
                  </label>
                  <input
                    class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="alto"
                    type="number"
                    name="alto"
                    placeholder="altura del libro en 'cm' (centimetros)"
                    value="{{old('alto')}}"
                   >
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block mb-2 uppercase text-gray-500 font-bold" for="grid-city">
                    Peso (opcional)
                  </label>
                  <input
                    class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="peso"
                    type="number"
                    name="peso"
                    placeholder="Peso del libro en 'gr' (gramos)"
                    value="{{old('peso')}}"
                   >
            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                <label class="block mb-2 uppercase text-gray-500 font-bold" for="grid-city">
                    Grueso (opcional)
                  </label>
                  <input
                    class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="grueso"
                    type="number"
                    name="grueso"
                    placeholder="grueso del libro en 'cm' (centimetros)"
                    value="{{old('grueso')}}"
                   >
            </div>
        </div>
        {{-- fin seccion datos opcionales --}}
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
              <label class="mb-2 block uppercase text-gray-500 font-bold" >
                Resumen
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
                id="resumen"
                name="resumen"
                placeholder="Resumen del Libro"
                @error('resumen')
                border-red-500
                @enderror
                value="{{old('resumen')}}"
                rows="3"
                ></textarea>

                @error('resumen')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                @enderror
            </div>
        </div>



        <input
            type="submit"
            value="Agregar Libro"
            class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3 mt-5"
        />

    </form>



@endsection
