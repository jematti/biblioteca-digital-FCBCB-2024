@extends('layouts.app')


@section('contenido')
    <div class="container p-8 bg-white">
        <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6">
            <p class="text-gray-700 uppercase">
                <span class="font-semibold">Numero de Orden:</span>
                 {{ $order->id }}
            </p>
        </div>

        {{-- datos de contacto --}}
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-lg font-semibold uppercase">Envío</p>
                    @if ($order->envio_type != 1)
                        <p class="text-sm">Los Libros deben ser recogidos en tienda</p>
                        {{-- direccion de la tiendas donde se ubican los libros --}}
                        <p class="text-sm">Calle falsa 123</p>
                    @else
                        <p class="text-sm">Los Libros seran envíados a:</p>
                        <p class="text-sm">{{ $order->direccion }}</p>
                    @endif
                </div>

                <div>
                    <p class="text-lg font-semibold uppercase">Datos de Contacto</p>
                    <p class="text-sm">Persona que recibira el libro: {{ $order->nombre_contacto }}</p>
                    <p class="text-sm">Correo: {{ $order->correo_contacto }}</p>
                    <p class="text-sm">Telefono: {{ $order->telefono_contacto }}</p>
                    <p class="text-sm">Datos para la Factura: {{ $order->factura }}</p>

                </div>
            </div>
        </div>

        {{-- detalles de la orden --}}
        <div class="bg-white rounded-lg shadow-lg p-6 ">
            <p class="text-xl font-semibold">Resumen</p>
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
                                    <img class="h-32 object-cover mr-4"
                                    src="{{ asset('uploads').'/'.$item->options->imagen}}" alt="imagen de portada de libro">

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
        {{-- finalizar pago --}}
        <div class="bg-white rounded-lg shadow-lg p-6 flex justify-end">
            <div>
                <p class="text-sm font-semibold">
                    Subtotal: {{ $order->total - $order->costo_envio }} Bs
                </p>
                <p class="text-sm font-semibold">
                    Envio: {{ $order->costo_envio }} Bs
                </p>

                <p class="text-lg font-semibold">
                    Total: {{ $order->total }} Bs
                </p>
            </div>
        </div>
    </div>
@endsection
