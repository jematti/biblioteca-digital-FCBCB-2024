@extends('ui.nav')

@section('contenido-admin')

<div class="max-w-7xl mx-auto ">
    <h2 class=" my-5  bg-custom-100 text-white uppercase text-lg rounded-lg p-4 text-center font-bold ">Reporte de Ordenes de Compra</h2>
    <form  action="{{ route('order.pdf') }}" method="POST" novalidate target="_blank">
        @csrf
        <div class="md:grid md:grid-cols-3 gap-5">
            <div class="mb-5">
                <label class="block mb-1 text-sm text-gray-700 uppercase font-bold">Fecha de Inicio *</label>
                <input class="appearance-none block w-full  text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('fecha_inicio') border-red-500 @enderror" id="fecha_inicio" name="fecha_inicio" type="date" placeholder="fecha de publicación del Libro" value="{{old('fecha_inicio')}}" />

                @error('fecha_inicio')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-5">
                <label class="block mb-1 text-sm text-gray-700 uppercase font-bold">Fecha de Fin *</label>
                <input class="appearance-none block w-full  text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('fecha_fin') border-red-500 @enderror" id="fecha_fin" name="fecha_fin" type="date" placeholder="fecha de publicación del Libro" value="{{old('fecha_fin')}}" />

                @error('fecha_fin')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block mb-1 text-sm text-gray-700 uppercase font-bold">Ordenes de Compra *</label>
                <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="order_type" name="order_type">
                    {{ $order_type="" }}
                    <option value="">-- Seleccione el tipo de orden --</option>
                    <option value="1" >PENDIENTES</option>
                    <option value="2" >RECIBIDOS</option>
                    <option value="3" >ENVIADOS</option>
                    <option value="4" >ENTREGADOS</option>
                    <option value="5" >ANULADOS</option>
                    <option value="6" >TODOS</option>
                </select>
                @error('order_type')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end">
            <input type="submit" class="bg-indigo-500 hover:bg-indigo-600 transition-colors text-white text-sm font-bold px-10 py-2 rounded cursor-pointer uppercase w-1/2" value="Generar Reporte PDF" />
        </div>
    </form>
</div>
@endsection
