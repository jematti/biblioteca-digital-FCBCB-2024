@extends('layouts.app')


@section('contenido')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 ">

        <h1 class="text-4xl text-white">
            Tienda Virtual <span class="font-bold">FC-BCB</span>
        </h1>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">

            <div class="mb-4 text-sm text-gray-600">
                ¿Olvidaste tu Contraseña? coloca tu email de registro y enviaremos un enlace para que puedas crear uno nuevo
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('password.email') }}" novalidate>
                @csrf

                <!-- Email Address -->
                <div>
                    <label class="block font-medium text-sm text-gray-700" for="email" value="Email">
                        Email
                    </label>
                    <input  id="email" class="block mt-1 w-full rounded-lg" type="email" name="email" value="{{old('email')}}" required autofocus />
                </div>

                <div class="flex justify-between my-5">
                    <a class="underline text-sm text-gray-600  hover:text-gray-900" href='{{ route('login') }}'>Iniciar Sesión</a>
                    <a class="underline text-sm text-gray-600  hover:text-gray-900" href='{{ route('register') }}'>Crear Cuenta</a>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3">
                        Enviar Instrucciones
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
