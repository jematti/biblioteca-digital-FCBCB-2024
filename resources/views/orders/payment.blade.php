@extends('layouts.app')


@section('contenido')
<div class="container mx-auto grid lg:grid-cols-5 grid-cols-1  gap-6  p-8 bg-white ">
    <div class="col-span-3">
        <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6 border-2 border-custom-100">
            <p class="text-gray-700 uppercase text-lg font-extrabold">
                <span class="font-semibold">Numero de Orden:</span>
                {{$order->id}}
            </p>
        </div>

        {{-- datos de contacto --}}
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6 border border-gray-400">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-lg font-semibold  text-blue-500  uppercase">Envío</p>

                    <p class="text-sm">Los Libros seran envíados a:</p>
                    <p class="text-sm">{{ $order->direccion }}</p>
                </div>

                <div>
                    <p class="text-lg font-semibold text-blue-500  uppercase">Datos de Contacto</p>
                    <p class="text-sm">Persona que recibira el libro: {{ $order->nombre_contacto }}</p>
                    <p class="text-sm">Correo: {{ $order->correo_contacto }}</p>
                    <p class="text-sm">Telefono: {{ $order->telefono_contacto }}</p>
                    <hr>
                    <p class="text-lg font-semibold uppercase text-blue-500 ">Datos para la Factura: </p>
                    <p class="text-base font-semibold">Nombre/Razon Social: {{ $order->nombre_factura}}</p>
                    <p class="text-base font-semibold">NIT : {{ $order->nit_factura}}</p>


                </div>
            </div>
        </div>

        {{-- detalles de la orden --}}
        <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-400">
            <p class="text-xl font-semibold text-red-500">Resumen</p>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th></th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @foreach ($items as $item)
                    <tr>
                        <td>
                            <div>
                                <img class="h-32 object-cover mr-4" src="{{ asset('uploads').'/'.$item->options->imagen}}" alt="imagen de portada de libro">

                                <article>
                                    <h1 class="font-bold">{{ $item->name }}</h1>
                                </article>
                            </div>
                        </td>
                        <td class="text-center">{{ $item->price }}Bs</td>
                        <td class="text-center">{{ $item->qty }}</td>
                        <td class="text-center">{{ $item->price * $item->qty }} Bs</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <hr>

    </div>
    <div class="col-span-2">
        {{-- finalizar pago --}}
        <div class="bg-white text-lg rounded-lg shadow-lg p-6 my-5 flex border border-gray-500">
            <div>
                <p class="font-semibold">
                    Subtotal: {{ $order->total - $order->costo_envio }} Bs
                </p>
                <p class="font-semibold">
                    Envio: {{ $order->costo_envio }} Bs
                </p>

                <p class=" text-xl font-semibold">
                    Total: {{ $order->total }} Bs
                </p>
            </div>

        </div>
        <button
                onclick="location.href = '{{ route('orders.pay',$order) }}'"
                class="w-full px-16 bg-red-500 hover:bg-red-400 text-white font-bold py-2 rounded-lg ">
                Confirmación de Compra
        </button>

        {{-- <button
                onclick="location.href = '{{  URL::previous() }}'"
                class="w-full px-16 bg-red-500 hover:bg-red-400 text-white font-bold py-2 mt-15 rounded-lg ">
                cancelar
        </button> --}}
    </div>
</div>
@endsection
