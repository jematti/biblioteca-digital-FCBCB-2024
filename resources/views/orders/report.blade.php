@extends('ui.nav')

@section('contenido-admin')

<div class="max-w-7xl mx-auto ">
        <h2 class=" my-5  bg-custom-100 text-white uppercase text-lg rounded-lg p-4 text-center font-bold ">Reporte de Ventas Realizadas</h2>
        <form>
            <div class="md:grid md:grid-cols-2 gap-5">
                <div class="mb-5">
                    <label
                        class="block mb-1 text-sm text-gray-700 uppercase font-bold "
                        for="termino">Término de Búsqueda
                    </label>
                    <input
                        id="termino"
                        type="text"
                        placeholder="Buscar por Término: ej. Laravel"
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full"
                    />
                </div>

                <div class="mb-5">
                    <label class="block mb-1 text-sm text-gray-700 uppercase font-bold">Categoría</label>
                    <select class="border-gray-300 p-2 w-full">
                        <option>--Seleccione--</option>

                        @foreach ($categories as $category )
                            <option value="{{ $category->id }}">{{ $category->nombre_categoria }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label class="block mb-1 text-sm text-gray-700 uppercase font-bold">Salario Mensual</label>
                    <select class="border-gray-300 p-2 w-full">
                        <option>-- Seleccione --</option>
                        @foreach ($repositories as $repository)
                            <option value="{{ $repository->id }}">{{$repository->nombre_repositorio}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label class="block mb-1 text-sm text-gray-700 uppercase font-bold">Salario Mensual</label>
                    <select class="border-gray-300 p-2 w-full">
                        <option>-- Seleccione --</option>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}">{{$author->nombre_autor}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end">
                <input
                    type="submit"
                    class="bg-indigo-500 hover:bg-indigo-600 transition-colors text-white text-sm font-bold px-10 py-2 rounded cursor-pointer uppercase w-full md:w-auto"
                    value="Buscar"
                />
            </div>
        </form>
    </div>
@endsection
