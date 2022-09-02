@extends('ui.nav')

@section('contenido-admin')

<div class="max-w-5xl">
    <h2 class="bg-custom-100 text-white uppercase text-lg rounded-lg p-4 text-center font-bold ">Agregar Categoría</h2>
    <form action="{{ route('category.update', $category->id) }}" method="POST" novalidate class="actualizar">

        @csrf
        @method('PUT')
        <div class="mb-5">
            <label for="nombre_categoria" class="mb-2 block uppercase text-gray-500 font-bold">
                Editar Categoría
            </label>
            <input id="nombre_categoria" type="text" name="nombre_categoria" placeholder="Ingrese el nombre de la categoria" class="border p-3 w-full rounded-lg @error('nombre_categoria') border-red-500 @enderror" value="{{$category->nombre_categoria}}" />
            @error('nombre_categoria')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
            @enderror

            {{-- botones de guardar - cancelar cambios --}}
            <div class="flex flex-row-reverse  my-5 text-right">
                <input type="submit" value="Guardar Cambios" class="w-1/2 text-white bg-sky-600 hover:bg-sky-700 uppercase font-bold focus:ring-4 font-lg rounded-lg text-sm px-5 py-2.5 text- mr-2 mb-2 " />
                <a class=" text-white bg-red-600 hover:bg-red-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 " href="{{ route('category.index') }}">Cancelar</a>
            </div>
    </form>
</div>


@endsection
