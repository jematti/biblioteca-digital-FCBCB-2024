@extends('layouts.app')


@section('contenido')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 ">

        <h1 class="text-4xl text-white">
            Tienda Virtual <span class="font-bold">FC-BCB</span>
        </h1>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">


            <div class="mb-4 text-sm text-gray-600">
                Es necesario confirmar tu cuenta antes de continuar, revisa tu email y presiona
                sobre el enlace de confirmación
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    Hemos enviado un nuevo email de confirmación a la cuenta
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div>
                        <button type="submit" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3">
                            Enviar email de confirmación
                        </button>
                    </div>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
