@extends('layouts.app')


@section('contenido')
<div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-white">

        <div class="flex justify-center items-center text-lg font-bold">
            Estado del pedido:
            @switch($order->estado)
            @case(1)
               <span class="font-bold p-1  mx-2 text-white  rounded-lg bg-orange-500">Pendiente</span>
            @break

            @case(2)
               <span class="font-bold p-1  mx-2 text-white rounded-lg bg-gray-500">Recibido</span>
            @break

            @case(3)
                <span class="font-bold p-1 mx-2 text-white rounded-lg bg-yellow-500">Enviado</span>
            @break

            @case(4)
                <span class="font-bold p-1 mx-2 text-white rounded-lg bg-blue-500">Entregado</span>
            @break

            @case(5)
                <span class="font-bold p-1 mx-2 text-white rounded-lg bg-red-500">Anulado</span>
            @break
            @default

            @endswitch
        </div>
        <div class="bg-white flex items-center rounded-lg shadow-lg px-6 py-6 mb-6">

            {{-- Estado del pedido --}}
            <div class="relative">
                <div class="{{ $order->estado >= 2 && $order->estado != 5 ? 'bg-blue-400' : 'bg-gray-400'}} rounded-full h-12 w-12  flex items-center justify-center">
                    <i class="fas fa-check text-white"></i>
                </div>

                <div class="absolute -left-1.5 mt-0.5">
                    <p>Recibido</p>
                </div>
            </div>

            <div class="{{ $order->estado >= 3 && $order->estado != 5 ? 'bg-blue-400' : 'bg-gray-400'}} h-1 flex-1 mx-2"></div>

            <div class="relative">
                <div class="{{ $order->estado >= 3 && $order->estado != 5 ? 'bg-blue-400' : 'bg-gray-400'}} rounded-full h-12 w-12 flex items-center justify-center">
                    <i class="fas fa-truck text-white"></i>
                </div>

                <div class="absolute -left-1 mt-0.5">
                    <p>Enviado</p>
                </div>
            </div>

            <div class="{{ $order->estado >= 4 && $order->estado != 5 ? 'bg-blue-400' : 'bg-gray-400'}} h-1 flex-1 mx-2"></div>

            <div class="relative">
                <div class="{{ $order->estado >= 4 && $order->estado != 5 ? 'bg-blue-400' : 'bg-gray-400'}} rounded-full h-12 w-12 flex items-center justify-center">
                    <i class="fas fa-check text-white"></i>
                </div>

                <div class="absolute -left-2 mt-0.5">
                    <p>Entregado</p>
                </div>
            </div>

            <div class="relative ml-10">
                <div class="{{ $order->estado == 5 ? 'bg-red-500' : 'bg-gray-400'}} rounded-full h-12 w-12 flex items-center justify-center">
                    <i class="fa-solid fa-xmark text-white"></i>
                </div>

                <div class="absolute -left-2 mt-0.5">
                    <p>Anulado</p>
                </div>
            </div>

            <div class="relative ml-6">
                <div class="{{ $order->estado == 1 ? 'bg-orange-400' : 'bg-gray-400'}} rounded-full h-12 w-12 flex items-center justify-center">
                    <i class="fas fa-business-time text-white"></i>
                </div>

                <div class="absolute -left-2 mt-0.5">
                    <p>Pendiente</p>
                </div>
            </div>


        </div>


        <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6 flex items-center">
            <p class="text-gray-700 uppercase">
                <span class="font-semibold">Numero de Orden:</span>
                {{ $order->id }}
            </p>
            {{-- boton enlace para ir a pagar --}}
            @if ($order->estado == 1)
            <button
                onclick="location.href = '{{ route('orders.payment',$order) }}'"
                class="ml-auto px-16 bg-red-500 hover:bg-red-400 text-white font-bold py-2 rounded-lg ">
                Adjuntar Pago
            </button>
            @endif
        </div>

        @if($order->estado == 1 || $order->estado == 5 || $order->observacion != "")
        <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6 border border-red-500">
            <p class="text-gray-700 uppercase">
                <span class="font-bold text-red-500">Observación:</span>
                {{$order->observacion}}
            </p>
        </div>
        @endif

        {{-- datos de contacto --}}
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-lg font-semibold uppercase">Envío</p>
                    @if ($order->tipo_envio == 2)
                    <p class="text-base">Los Libros deben ser recogidos en tienda</p>
                    {{-- direccion de la tiendas donde se ubican los libros --}}
                    <p class="text-base">Calle falsa 123</p>
                    @else
                    <p class="text-base">Los Libros seran envíados a:</p>
                    <p class="text-base">{{ $order->direccion }}</p>
                    @endif

                    <hr>
                    {{-- datos de pago total --}}
                    <p class="text-lg font-semibold text-red-500 uppercase">
                        Información de Pago
                    </p>
                    <p class="text-base font-semibold">
                        Subtotal: {{ $order->total - $order->costo_envio }} Bs
                    </p>
                    <p class="text-base font-semibold">
                        Envio: {{ $order->costo_envio }} Bs
                    </p>

                    <p class="text-xl font-semibold">
                        Total: {{ $order->total }} Bs
                    </p>
                    {{-- fin de datos de pago total --}}
                </div>

                <div>
                    <p class="text-lg font-semibold uppercase">Datos de Contacto</p>
                    <p class="text-base">Persona que recibira el libro: {{ $order->nombre_contacto }}</p>
                    <p class="text-base">Correo: {{ $order->correo_contacto }}</p>
                    <p class="text-base">Telefono: {{ $order->telefono_contacto }}</p>
                    <hr>
                    <p class="text-lg font-semibold uppercase">Datos para la Factura: </p>
                    <p class="text-base font-semibold">Nombre/Razon Social: {{ $order->nombre_factura}}</p>
                    <p class="text-base font-semibold">NIT : {{ $order->nit_factura}}</p>

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
    </div>
</div>
@endsection
