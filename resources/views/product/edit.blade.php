@extends('ui.nav')

@section('contenido-admin')

{{-- mostrar estilos de dropzone solo en esta vista --}}
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<style>
    /* Estilos adicionales para ajustar el tamaño de la imagen */
    .dropzone img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
    }

    .dropzone {
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .dropzone .dz-preview .dz-image {
        max-width: 100%;
        max-height: 100%;
    }
</style>
@endpush

<h2 class="bg-custom-100 text-white uppercase text-lg rounded-lg p-4 text-center font-bold ">Editar Producto</h2>

<div class="flex lg:flex-row md:flex-col">

    <div class="mx-3 my-6">
        {{-- imagen de libro --}}
        <div class="mx-3 my-6">
            <div class="px-3">
                <label class="mb-2 block uppercase text-gray-500 font-bold">
                    Imagen del Libro
                </label>
                <form enctype="multipart/form-data" action="{{ route('imagenes.store') }}" method="POST" id="dropzone" class="dropzone actualizar border-dashed border-2 w-full h-96 rounded flex flex-col justify-center items-center">
                    @csrf
                </form>
            </div>
        </div>
        {{-- fin imagen de libro --}}
    </div>

    {{-- formulario de añadir libro --}}
    <div class="mx-3 my-6 flex-1">
        <form action="{{ route('products.update', ['product' => $product->id]) }}" method="POST" class="w-full actualizar" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')

            {{-- input img  del libro --}}
            <div class="mb-5">
                <input type="hidden" name="imagen" id="imagen" value="{{ $product->imagen }}">

                @error('imagen')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                @enderror
            </div>

            {{-- añadir PDF del Producto --}}
            <div class="px-3">
                <label class="mb-2 block uppercase text-gray-500 font-bold">
                    Archivo PDF del Producto
                </label>
                <input type="file" name="pdf" id="pdf" class="border border-gray-200 p-2 w-full rounded" accept=".pdf">
                @error('pdf')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                @enderror
            </div>
            {{-- fin input img  del libro --}}

            <div class="lg:grid lg:grid-cols-4 gap-5">
                <div class="col-span-2">
                    {{-- titulo de libro --}}
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="mb-2 block uppercase text-gray-500 font-bold">
                                Título del Libro
                            </label>
                            <textarea class="
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
                                focus:text-neutral-700
                                focus:border-gray-600"
                                id="titulo" name="titulo" placeholder="Poner el título del Libro"
                                @error('titulo')
                                border-red-500
                                @enderror
                                value="{{$product->titulo}}"
                                rows="3">{{$product->titulo}}</textarea>


                            @error('titulo')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- resumen del libro --}}
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">

                            <label class="mb-2 block uppercase text-gray-500 font-bold">
                                Resumen
                            </label>
                            <textarea class="
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
                                focus:text-neutral-700
                                focus:border-gray-600"
                                id="resumen" name="resumen" placeholder="Resumen del Libro" @error('resumen') border-red-500 @enderror value="{{$product->resumen}}" rows="5">{{ $product->resumen }}</textarea>

                            @error('resumen')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- lista de repositorios --}}
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="mb-2 block uppercase text-gray-500 font-bold">
                                Ubicación:
                            </label>
                            <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="ubicacion" name="ubicacion">
                                <option disabled selected>- Seleccione una Autor -</option>

                                @foreach ($repositories as $repository)
                                <option {{ $product->repository->id == $repository->id ? 'selected' : '' }} value="{{ $repository->id }}">
                                    {{$repository->ciudad}} | {{$repository->nombre_repositorio}}
                                </option>
                                @endforeach

                            </select>

                            @error('ubicacion')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- lista de autores del libro --}}
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="mb-2 block uppercase text-gray-500 font-bold">
                                Autor:
                            </label>

                            <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="author" name="author">
                                <option disabled selected>- Seleccione una Autor -</option>

                                @foreach ($authors as $author)
                                <option {{ $product->author->id == $author->id ? 'selected' : '' }} value="{{ $author->id }}">
                                    {{$author->nombre_autor}}
                                </option>
                                @endforeach

                            </select>

                            @error('author')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- lista de Categorias --}}
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="mb-2 block uppercase text-gray-500 font-bold">
                                Categoría:
                            </label>

                            <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="category" name="category">
                                <option disabled selected>- Seleccione una categoría -</option>

                                @foreach ($categories as $category)
                                <option {{ $product->category->id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">
                                    {{$category->nombre_categoria}}
                                </option>
                                @endforeach
                            </select>

                            @error('category')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-span-2">
                    {{-- lista de idiomas --}}
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="mb-2 block uppercase text-gray-500 font-bold">
                                Idioma:
                            </label>
                            <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="idioma" name="idioma">

                                <option disabled selected>- Seleccione el idioma del Libro- </option>

                                <option value="español" {{ ($product->idioma)=='español' ? 'selected' : ''  }}>Español</option>
                                <option value="aymara" {{ ($product->idioma)=='aymara' ? 'selected' : ''  }}>Aymara</option>
                                <option value="quechua" {{ ($product->idioma)=='quechua' ? 'selected' : ''  }}>Quechua</option>
                                <option value="ingles" {{ ($product->idioma)=='ingles' ? 'selected' : ''  }}>Ingles</option>

                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
                            </div>
                            @error('idioma')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                     {{-- precio - stock del libro --}}
                     <div class="flex flex-wrap -mx-3 mb-3 ">
                        <div class="w-full md:w-1/2 px-3">
                            <label class="mb-2 block uppercase text-gray-500 font-bold">
                                Precio del Libro
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="precio" name="precio" type="number" min="1" pattern="^[0-9]+" placeholder="Precio del Libro" @error('precio') border-red-500 @enderror value="{{$product->precio}}" />

                            @error('precio')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/2 px-3">
                            <label class="mb-2 block  text-gray-500 font-bold">
                                STOCK <span class="font-medium">(numero de copias del libro)</span>
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="cantidad" name="cantidad" type="number" min="1" pattern="^[0-9]+" Step=".01" placeholder="Precio del Libro" @error('cantidad') border-red-500 @enderror value="{{$product->cantidad}}" />

                            @error('cantidad')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- paginas - edicion del libro --}}
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block mb-2 uppercase text-gray-500 font-bold" for="grid-city">
                                Páginas
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="numero_paginas" type="number" min="1" pattern="^[0-9]+" name="numero_paginas" placeholder="Nro de Páginas" @error('numero_paginas') border-red-500 @enderror value="{{ $product->numero_paginas }}">

                            @error('numero_paginas')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/2 px-3">
                            <label class="block mb-2 uppercase text-gray-500 font-bold" for="grid-city">
                                Edición
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="edicion" name="edicion" type="text" placeholder="Ej: Primera Edición" @error('edicion') border-red-500 @enderror value="{{$product->edicion}}">
                            @error('edicion')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- fecha de publicacion y ISBN del libro --}}
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="mb-2 block uppercase text-gray-500 font-bold">
                                Fecha de Publicación
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="fecha_publicacion" name="fecha_publicacion" type="date" placeholder="fecha de publicación del Libro @error('fecha_publicacion') border-red-500 @enderror" value="{{$product->fecha_publicacion}}" />

                            @error('fecha_publicacion')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="mb-2 block  text-gray-500 font-bold">
                                ISBN <span class="font-medium">(Si corresponde)</span>
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="isbn" name="isbn" type="text" placeholder="codigo ISBN del Libro" @error('isbn') border-red-500 @enderror value="{{$product->isbn}}" />

                            @error('isbn')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- datos opcionales (ALTO,ANCHO,PESO,GRUESO)--}}
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block mb-2  text-gray-500 font-bold" for="grid-city">
                                ANCHO <span class="font-medium">(opcional)</span>
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="ancho" type="number" min="1" pattern="^[0-9]+" name="ancho" placeholder="Ancho del libro en 'cm' (centimetros)" value="{{$product->ancho}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                            <label class="block mb-2  text-gray-500 font-bold" for="grid-city">
                                ALTO <span class="font-medium">(opcional)</span>
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="alto" type="number" min="1" pattern="^[0-9]+" name="alto" placeholder="altura del libro en 'cm' (centimetros)" value="{{$product->alto}}">
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block mb-2  text-gray-500 font-bold" for="grid-city">
                                PESO<span class=" font-medium">(opcional)</span>
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="peso" type="number" min="1" pattern="^[0-9]+" name="peso" placeholder="Peso del libro en 'gr' (gramos)" value="{{$product->ancho}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                            <label class="block mb-2  text-gray-500 font-bold" for="grid-city">
                                GRUESO <span class=" font-medium">(opcional)</span>
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grueso" type="number" min="1" pattern="^[0-9]+" name="grueso" placeholder="grueso del libro en 'cm' (centimetros)" value="{{$product->grueso}}">
                        </div>
                    </div>
                    {{-- fin seccion datos opcionales --}}

                    {{-- botones de guardar - cancelar cambios --}}
                    <div class="flex flex-row-reverse  my-5 text-right">
                        <input type="submit" value="Guardar Cambios" class="w-1/2 text-white bg-sky-600 hover:bg-sky-700 uppercase font-bold focus:ring-4 font-lg rounded-lg text-sm px-5 py-2.5 text- mr-2 mb-2 " />
                        <a class=" text-white bg-red-600 hover:bg-red-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 " href="{{ route('products.index') }}">Cancelar</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    {{-- fin de seccion de formulario de añadir libro --}}
</div>

@endsection
