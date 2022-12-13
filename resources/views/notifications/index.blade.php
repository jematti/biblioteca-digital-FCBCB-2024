@extends('ui.nav')

@section('contenido-perfil')
<div class="max-w-5xl">
    <h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Mis Notificaciones</h2>
    @forelse ($notifications as $notification)
    <div class="p-5 border text-base border-gray-200 lg:flex lg:justify-between lg:items-center">
        <div class="flex">
            <p>
                <span class="w-12 text-center">
                    @switch($notification->data['estado'])
                    @case(1)
                    <i class="fas fa-business-time fa-2xl mx-5 text-orange-500 "></i>
                    <p class="px-2 pt-1">Tiene una notificación de Orden de Compra </p>
                    <span class="font-bold p-1  mx-2 text-white  rounded-lg bg-orange-500">Pendiente</span>
                    @break
                    @case(2)
                    <i class="fas fa-credit-card fa-2xl mx-5 text-gray-500 "></i>
                    <p class="px-2 pt-1">Tiene una notificación de Orden de Compra </p>
                    <span class="font-bold p-1  mx-2 text-white rounded-lg bg-gray-500">Recibido</span>
                    @break

                    @case(3)
                    <i class="fas fa-truck fa-2xl mx-5  text-yellow-400"></i>
                    <p class="px-2 pt-1">Tiene una notificación de Orden de Compra </p>
                    <span class="font-bold p-1 mx-2 text-white rounded-lg bg-yellow-500">Enviado</span>
                    @break


                    @case(4)
                    <i class="fas fa-truck fa-2xl mx-5  text-blue-400"></i>
                    <p class="px-2 pt-1">Tiene una notificación de Orden de Compra </p>
                    <span class="font-bold p-1 mx-2 text-white rounded-lg bg-blue-500">Entregado</span>
                    @break

                    @case(5)
                    <i class="fas fa-times-circle fa-2xl mx-5 text-red-500 "></i>
                    <p class="px-2 pt-1">Tiene una notificación de Orden de Compra </p>
                    <span class="font-bold p-1 mx-2 text-white rounded-lg bg-red-500">Anulado</span>
                    @break
                    @default

                    @endswitch
                </span>
            </p>
        </div>

        <div>
            <span class="font-bold">
                {{ $notification->created_at->diffForHumans() }}
            </span>
        </div>
        @can('admin.orders.show')
        <div class="mt-5 lg:mt-0">
            <a href="{{ url("/admin/orders/{$notification->data['id_order'] }") }}" class="bg-teal-400 p-3 uppercase font-bold text-white rounded-lg">
                Ver Orden
            </a>
        </div>
        @endcan
        @can('nav.users')
        <div class="mt-5 lg:mt-0">
            <a href="{{ url("/orders/{$notification->data['id_order'] }") }}" class="bg-teal-400 p-3 uppercase font-bold text-white rounded-lg">
                Ver Orden
            </a>
        </div>
        @endcan

    </div>
    @empty
    <p class="text-center text-xl text-gray-600 mt-10  rounded-lg uppercase font-bold"><i class="fa-solid fa-circle-exclamation"></i>No hay Notificaciones Nuevas</p>
    @endforelse
</div>
@endsection
