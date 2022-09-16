@extends('layouts.app')


@section('contenido')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 ">

        <h1 class="text-4xl text-white">
            Tienda Virtual <span class="font-bold">FC-BCB</span>
        </h1>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">


            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('password.update') }}"  onsubmit="document.getElementById('submit').disabled=true; processFormData();" >
                @csrf
                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <label class="block font-medium text-sm text-gray-700" for="email" value="Email">
                        Email
                    </label>
                    <input id="email" class="block mt-1 w-full rounded-lg" type="email" name="email"
                        value="{{ old('email') }}" required autofocus />
                </div>


                <!-- Password -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="password" value="Password">
                        Contraseña
                    </label>

                    <input id="password" class="block mt-1 w-full" type="password" name="password" required />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="password_confirmation" value="Confirm Password">
                    Confirmar Contraseña
                    </label>
                    <input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
                        required />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button id="submit" type="submit" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3">
                        Resetear Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
