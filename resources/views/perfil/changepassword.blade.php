@extends('ui.nav')

@section('contenido-perfil')
<div class="max-w-5xl">
    <h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Cambiar Contraseña</h2>

    <form action="{{ route('updatepassword') }}" method="POST" novalidate>
        @csrf

        @if (session('status'))
        <div class="bg-green-100 rounded-lg py-5 px-6 mb-3 mt-3 text-base text-green-700 inline-flex items-center w-full" role="alert">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check-circle" class="w-4 h-4 mr-2 fill-current" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path>
            </svg>
            {{ session('status') }}
        </div>

        @elseif (session('error'))
        <div role="alert">
            <div class="bg-red-500 text-white font-bold rounded-t px-4 mt-3 py-2">
                Error
            </div>
            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                <p>{{ session('error') }}</p>
            </div>
        </div>
        @endif
        <div class="mb-5">
            <label for="old_password" class="mb-2 block uppercase text-gray-500 font-bold border">
                Contraseña Actual
            </label>
            <input id="old_password" type="password" name="old_password" placeholder="Escribe Contraseña de Actual" class="border p-3 w-full rounded-lg @error('old_password') border-red-500 @enderror" value="{{old('old_password')}}" />
            @error('old_password')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
            @enderror

            <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                Nueva Contraseña
            </label>
            <input id="password" type="password" name="password" placeholder="Escribe Contraseña de Registro" class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror" value="{{old('password')}}" />
            @error('password')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
            @enderror
            <label for="password_confirmation" class="mb-2 block uppercase text-gray-500 font-bold">
                Confirme su nueva Contraseña
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Repite Tu Contraseña" class="border p-3 w-full rounded-lg" />

            <input type="submit" value="Confirmar" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3 mt-5" />
        </div>
    </form>
</div>

@endsection
