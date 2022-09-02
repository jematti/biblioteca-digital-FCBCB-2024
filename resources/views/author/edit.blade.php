@extends('ui.nav')

@section('contenido-admin')
<div class="max-w-5xl">
    <h2 class="bg-custom-100 text-white uppercase text-lg rounded-lg p-4 text-center font-bold ">Autor</h2>

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
            transition
            ease-in-out
            m-0
            focus:text-neutral-700 focus:bg-white focus:border-gray-600 focus:outline-none"
           id="biografia" name="biografia" placeholder="Biografia del Autor" @error('biografia') border-red-500 @enderror value="{{$author->biografia}}" rows="3">{{$author->biografia}}</textarea>

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
</div>

@endsection
{{--
@section('js')


@endsection --}}
