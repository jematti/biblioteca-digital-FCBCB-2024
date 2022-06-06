@extends('ui.adminnav')

@section('contenido-admin')

<h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Agregar Categoría</h2>
<form action="{{ route('category.update', $category->id) }}" method="POST" novalidate>

    @csrf
    @method('PUT')
    <div class="mb-5">
        <label for="nombre_categoria" class="mb-2 block uppercase text-gray-500 font-bold">
            Editar Categoría
        </label>
        <input
            id="nombre_categoria"
            type="text"
            name="nombre_categoria"
            placeholder="Ingrese el nombre de la categoria"
            class="border p-3 w-full rounded-lg"
            @error('nombre_categoria')
                border-red-500
            @enderror
            value="{{$category->nombre_categoria}}"
        />
        @error('nombre_categoria')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
        @enderror

        <label for="descripcion" class="mb-2 block uppercase text-gray-500 font-bold">
            Descripción de Categoría (Opcional)
        </label>
        <input
            id="descripcion"
            type="text"
            name="descripcion"
            placeholder="numero de edicion"
            class="border p-3 w-full rounded-lg"
            @error('descripcion')
                border-red-500
            @enderror
            value="{{$category->descripcion}}"
        />
        @error('descripcion')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
        @enderror

        <input
            type="submit"
            value="Actualizar Categoría"
            class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3 mt-5"
        />

</form>


@endsection
