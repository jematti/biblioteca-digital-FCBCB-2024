@extends('ui.nav')

@section('contenido-admin')
<div class="container py-6">
    {{-- seccion de tarjetas con el resumen de compras echas por el usuario --}}
    <section class="grid lg:grid-cols-5 gap-5 text-white">

        <a href="{{ route('orders.index') . "?estado=1" }} " class="bg-orange-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
            <p class="text-center text-2xl">
                {{ $pendiente }}
            </p>
            <p class="uppercase text-center">Pendiente</p>
            <p class="text-center text-2xl mt-2">
                <i class="fas fa-business-time"></i>
            </p>
        </a>

        <a href="{{ route('orders.index') . "?estado=2" }} " class="bg-gray-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
            <p class="text-center text-2xl">
                {{ $recibido }}
            </p>
            <p class="uppercase text-center">Recibido</p>
            <p class="text-center text-2xl mt-2">
                <i class="fas fa-credit-card"></i>
            </p>
        </a>


        <a href="{{ route('orders.index') . "?estado=3" }} " class="bg-green-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
            <p class="text-center text-2xl">
                {{ $enviado }}
            </p>
            <p class="uppercase text-center">Enviado</p>
            <p class="text-center text-2xl mt-2">
                <i class="fas fa-truck"></i>
            </p>
        </a>

        <a href="{{ route('orders.index') . "?estado=4" }} " class="bg-blue-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
            <p class="text-center text-2xl">
                {{ $entregado }}
            </p>
            <p class="uppercase text-center">Entregado</p>
            <p class="text-center text-2xl mt-2">
                <i class="fas fa-check-circle"></i>
            </p>
        </a>

        <a href="{{ route('orders.index') . "?estado=5" }} " class="bg-red-500 bg-opacity-75 rounded-lg pt-8 pb-4">
            <p class="text-center text-2xl">
                {{ $anulado }}
            </p>
            <p class="uppercase text-center">Anulado</p>
            <p class="text-center text-2xl mt-2">
                <i class="fas fa-times-circle"></i>
            </p>
        </a>
    </section>

    @if ($orders->count() > 0)
        {{-- listado de todos los pedidos echos por el usuario --}}
        <section class="bg-white shadow-lg rounded-lg px-12 py-8 mt-12 text-gray-700">
            <h1 class="text-2xl mb-4">
                Pedidos recientes
            </h1>

            <ul class="divide-y">
                @foreach ($orders as $order)
                <li>
                    <a href="{{ route('orders.show',$order) }}" class="flex items-center py-2 px-4 hover:bg-gray-100">
                        <span class="w-12 text-center">
                            @switch($order->estado)
                            @case(1)
                            <i class="fas fa-business-time text-orange-500 "></i>
                            @break
                            @case(2)
                            <i class="fas fa-credit-card text-gray-500 "></i>
                            @break

                            @case(3)
                            <i class="fas fa-truck text-yellow-400 "></i>
                            @break

                            @case(4)
                            <i class="fas fa-check-circle text-blue-500 "></i>
                            @break

                            @case(5)
                            <i class="fas fa-times-circle text-red-500 "></i>
                            @break
                            @default

                            @endswitch
                        </span>

                        <span>
                            Orden: {{ $order->id }}
                            <br>
                            {{ $order->created_at->format('d/m/Y') }}
                        </span>

                        <div class="ml-auto ">
                            <span class="font-bold">
                                @switch($order->estado)
                                @case(1)
                                    Pendiente
                                @break

                                @case(2)
                                    Recibido
                                @break

                                @case(3)
                                    Enviado
                                @break

                                @case(4)
                                    Entregado
                                @break

                                @case(5)
                                    Anulado
                                @break
                                @default

                                @endswitch
                            </span>
                            <br>
                            <span class="text-sm">
                                {{ $order->total }} Bs
                            </span>
                        </div>

                        <span>
                            <i class="fas fa-angle-right ml-6"></i>
                        </span>
                    </a>
                </li>
                @endforeach
            </ul>
        </section>
    @else
        <div class="bg-white shadow-lg rounded-lg px-12 py-8 mt-12 ">
            <span class="font-bold text-lg">
                No hay pedidos
            </span>
        </div>
    @endif
</div>
@endsection
