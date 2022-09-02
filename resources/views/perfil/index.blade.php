@extends('ui.nav')

@section('contenido-perfil')

<div class="max-w-5xl">
    <h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Editar Perfil</h2>
    @if (session('status'))
    <div class="bg-green-100 rounded-lg py-5 px-6 mb-3 mt-3 text-base text-green-700 inline-flex items-center w-full" role="alert">
        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check-circle" class="w-4 h-4 mr-2 fill-current" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path>
        </svg>
        {{ session('status') }}
    </div>

    @endif
    <form class="actualizar" action="{{ route('perfil.store') }}" method="POST" novalidate>
        @csrf
        <div class="mb-5">

            <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">
                Nombre
            </label>
            <input id="name" type="text" name="name" placeholder="Tu Nombre Completo" class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror" value="{{auth()->user()->name}}" />
            @error('name')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
            @enderror
            <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                Correo Electronico
            </label>
            <input id="email" type="email" name="email" placeholder="Tu correo electronico de registro" class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror" value="{{auth()->user()->email}}" />
            @error('email')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
            @enderror

            <input type="submit" value="Actualizar Datos" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3 mt-5" />
        </div>
    </form>
</div>
@endsection
