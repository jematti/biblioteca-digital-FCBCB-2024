@extends('ui.adminnav')

@section('contenido-admin')

    <h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Editorial</h2>

   {{-- formulario para agregar editorial --}}
    <form action="{{ route('editorial.update',$editorial->id) }}" method="POST" novalidate>

        @csrf
        @method('PUT')
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
                value="{{$editorial->nombre_editorial}}"
            />
            @error('nombre_editorial')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
            @enderror

            <label for="direccion" class="mb-2 block uppercase text-gray-500 font-bold">
                Descripción de Categoría (Opcional)
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
                value="{{$editorial->direccion}}"
            />
            @error('direccion')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
            @enderror

            <label for="contacto" class="mb-2 block uppercase text-gray-500 font-bold">
                Descripción de Categoría (Opcional)
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
                value="{{$editorial->contacto}}"
            />
            @error('contacto')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
            @enderror

            {{-- botones de guardar - cancelar cambios --}}
            <div class="flex flex-row-reverse  my-5 text-right">
                <input
                    type="submit"
                    value="Guardar Cambios"
                    class="w-1/2 text-white bg-sky-600 hover:bg-sky-700 uppercase font-bold focus:ring-4 font-lg rounded-lg text-sm px-5 py-2.5 text- mr-2 mb-2 "
                />
                <a class=" text-white bg-red-600 hover:bg-red-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 " href="{{ route('editorial.index') }}">Cancelar</a>
            </div>

    </form>


@endsection
