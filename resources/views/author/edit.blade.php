@extends('ui.nav')

@section('contenido-admin')

    <h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Autor</h2>

   {{-- formulario para agregar Autor --}}
    <form action="{{ route('author.update',$author->id) }}" method="POST" class="actualizar" novalidate>

        @csrf
        @method('PUT')
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
                value="{{$author->nombre_autor}}"
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
                value="{{$author->biografia}}"
            />
            @error('biografia')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
            @enderror

            {{-- botones de guardar - cancelar cambios --}}

            <div class="flex flex-row-reverse  my-5 text-right">
                    <input
                        type="submit"
                        value="Guardar Cambios"

                        class="w-1/2 text-white bg-sky-600 hover:bg-sky-700 uppercase font-bold focus:ring-4 font-lg rounded-lg text-sm px-5 py-2.5 text- mr-2 mb-2 "
                    />
                    <a class=" text-white bg-red-600 hover:bg-red-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 " href="{{ route('author.index') }}">Cancelar</a>
            </div>


    </form>


@endsection
{{--
@section('js')


@endsection --}}
