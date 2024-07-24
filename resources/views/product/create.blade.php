@extends('ui.nav')

@section('contenido-admin')

{{-- mostrar estilos de dropzone solo en esta vista --}}
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

<h2 class="bg-custom-100 text-white uppercase text-lg rounded-lg p-4 text-center font-bold ">Agregar Producto</h2>

<div class="flex lg:flex-row md:flex-col">
    {{-- imagen del Producto --}}

    <div class="mx-3 my-6">
        <div class="px-3">
            <label class="mb-2 block uppercase text-gray-500 font-bold">
                Imagen del Producto
            </label>
            <form enctype="multipart/form-data" action="{{ route('imagenes.store') }}" method="POST" id="dropzone" class="dropzone border-dashed border-2 w-full h-96 rounded flex flex-col justify-center items-center">
                @csrf
            </form>
        </div>
        
        
    </div>
    {{-- fin imagen del Producto --}}

    

    {{-- formulario de añadir Producto --}}
    <div class="mx-3 my-6 flex-1">
        <form action="{{ route('products.store') }}" method="POST" class="w-full " enctype="multipart/form-data" novalidate>
            @csrf
            {{-- input imagen --}}
            <div>
                <input type="hidden" name="imagen" id="imagen" value="{{ old('imagen') }}">

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
        {{-- fin añadir PDF del Producto --}}

            <div class="lg:grid lg:grid-cols-4 gap-5">
                <div class="col-span-2">
                    {{-- titulo/nombre del Producto --}}
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
                                border border-solid
                                rounded
                                focus:text-neutral-700
                                focus:border-gray-600
                                @error('titulo')
                                border-red-500
                                @enderror"
                                id="titulo" name="titulo" placeholder="Poner el título del Libro"

                                value="{{old('titulo')}}"
                                 rows="3"></textarea>

                            @error('titulo')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- resumen del Producto --}}
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
                                border border-solid
                                rounded
                                focus:text-neutral-700
                                focus:border-gray-600
                                @error('resumen') border-red-500 @enderror"
                                id="resumen" name="resumen" placeholder="Resumen del Libro"  value="{{old('resumen')}}" rows="5"></textarea>

                            @error('resumen')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- ubicacion del Producto (repositorios) --}}
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="mb-2 block uppercase text-gray-500 font-bold">
                                Ubicación:
                            </label>
                            <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="ubicacion" name="ubicacion">
                                <option disabled selected>- Seleccione una Ubicación -</option>

                                @foreach ($repositories as $repository)
                                <option {{ old('ubicacion') == $repository->id ? 'selected' : '' }} value="{{ $repository->id }}">
                                    {{$repository->ciudad}} | {{$repository->nombre_repositorio}}
                                </option>
                                @endforeach

                            </select>

                            @error('ubicacion')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- listado de autores --}}
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="mb-2 block uppercase text-gray-500 font-bold">
                                Autor:
                            </label>

                            <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="author" name="author">
                                <option disabled selected>- Seleccione una Autor -</option>

                                @foreach ($authors as $author)
                                <option {{ old('author') == $author->id ? 'selected' : '' }} value="{{ $author->id }}">
                                    {{$author->nombre_autor}}
                                </option>
                                @endforeach

                            </select>

                            @error('author')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- listado de categorias de los Productos --}}
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="mb-2 block uppercase text-gray-500 font-bold">
                                Categoría:
                            </label>

                            <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="category" name="category">
                                <option value="" disabled selected>- Seleccione una categoría -</option>

                                @foreach ($categories as $category)
                                <option {{ old('category') == $category->id ? 'selected' : '' }} value="{{ $category->id }}">
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
                      {{-- listado de Idiomas  --}}
                      <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="mb-2 block uppercase text-gray-500 font-bold">
                                Idioma:
                            </label>
                            <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="idioma" name="idioma">
                                {{ $idioma="" }}
                                <option value="">- Seleccione el idioma del Libro- </option>
                                <option value="español" {{ old('idioma',$idioma)=='español' ? 'selected' : ''  }}>Español</option>
                                <option value="aymara" {{ old('idioma',$idioma)=='aymara' ? 'selected' : ''  }}>Aymara</option>
                                <option value="quechua" {{ old('idioma',$idioma)=='quechua' ? 'selected' : ''  }}>Quechua</option>
                                <option value="ingles" {{ old('idioma',$idioma)=='ingles' ? 'selected' : ''  }}>Ingles</option>

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
                    {{-- precio - stock  del Producto --}}
                    <div class="flex flex-wrap -mx-3 mb-3">
                        <div class="w-full md:w-1/2 px-3">
                            <label class="mb-2 block uppercase text-gray-500 font-bold">
                                Precio del Libro
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('precio') border-red-500 @enderror" id="precio" name="precio" type="number" min="1" pattern="^[0-9]+" placeholder="Precio del Libro"  value="{{old('precio')}}" />

                            @error('precio')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/2 px-3">
                            <label class="mb-2 block  text-gray-500 font-bold">
                                STOCK <span class=" font-medium">(Nro. de copias del libro)</span>
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('cantidad') border-red-500 @enderror" id="cantidad" name="cantidad" type="number" min="1" pattern="^[0-9]+" placeholder="Nro de Ejemplares"  value="{{old('cantidad')}}" />

                            @error('cantidad')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    {{-- nro de paginas y edicion del Producto --}}
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block mb-2 uppercase text-gray-500 font-bold" for="grid-city">
                                Páginas
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('numero_paginas') border-red-500 @enderror" id="numero_paginas" type="number" min="1" pattern="^[0-9]+" name="numero_paginas" placeholder="Nro de Páginas"  value="{{old('numero_paginas')}}">

                            @error('numero_paginas')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/2 px-3">
                            <label class="block mb-2 uppercase text-gray-500 font-bold" for="grid-city">
                                Edición
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('edicion') border-red-500 @enderror" id="edicion" name="edicion" type="text" placeholder="Ej: Primera Edición"  value="{{old('edicion')}}">
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
                            <input class="appearance-none block w-full  text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('fecha_publicacion') border-red-500 @enderror" id="fecha_publicacion" name="fecha_publicacion" type="date" placeholder="fecha de publicación del Libro"  value="{{old('fecha_publicacion')}}" />

                            @error('fecha_publicacion')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="mb-2 block text-gray-500 font-bold">
                                ISBN <span class=" font-medium">(Si corresponde)</span>
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border  rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="isbn" name="isbn" type="text" placeholder="codigo ISBN del Libro"  value="{{old('isbn')}}" />

                            @error('isbn')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- datos opcionales de libro (ALTO,ANCHO,PESO,GRUESO)--}}
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block mb-2  text-gray-500 font-bold" for="grid-city">
                                ANCHO cm. <span class=" font-medium">(opcional)</span>
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="ancho" type="number" name="ancho" placeholder="Ancho del libro en 'cm' (centimetros)" value="{{old('ancho')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                            <label class="block mb-2  text-gray-500 font-bold" for="grid-city">
                                ALTO cm. <span class=" font-medium">(opcional)</span>
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="alto" type="number" name="alto" placeholder="altura del libro en 'cm' (centimetros)" value="{{old('alto')}}">
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block mb-2  text-gray-500 font-bold" for="grid-city">
                                PESO gr. <span class=" font-medium">(opcional)</span>
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="peso" type="number" name="peso" placeholder="Peso del libro en 'gr' (gramos)" value="{{old('peso')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                            <label class="block mb-2  text-gray-500 font-bold" for="grid-city">
                                GRUESO cm. <span class=" font-medium">(opcional)</span>
                            </label>
                            <input class="appearance-none block w-full  text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grueso" type="number" name="grueso" placeholder="grueso del libro en 'cm' (centimetros)" value="{{old('grueso')}}">
                        </div>
                    </div>
                    {{-- fin seccion datos opcionales --}}

                    <input type="submit" value="Agregar Producto" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3" />
                </div>
            </div>

        </form>
    </div>
    {{-- fin de formulario de añadir Producto --}}
</div>




@endsection
