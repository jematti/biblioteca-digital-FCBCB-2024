@extends('ui.nav')

@section('contenido-perfil')
<div class="max-w-5xl">
    <h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Mis Notificaciones</h2>
    @forelse ($notifications as $notification)
    <div class="p-5 border border-gray-200 lg:flex lg:justify-between lg:items-center">
        <div>
            <p>Tiene una nueva notificación
                <span class="font-bold">
                    {{ $notification->data['usuario_id'] }}
                </span>
            </p>
            <p>Tiene una nueva notificación
                <span class="font-bold">
                    {{ $notification->created_at->diffForHumans() }}
                </span>
            </p>
        </div>
        <div class="mt-5 lg:mt-0">
            <a href="#" class="bg-teal-400 p-3 uppercase font-bold text-white rounded-lg">
                Ver Orden
            </a>
        </div>
    </div>
    @empty
    <p class="text-center text-gray-600"> No hay Notificaciones Nuevas</p>
    @endforelse
</div>
@endsection
