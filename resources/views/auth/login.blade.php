@extends('layouts.app')


@section('contenido')
    <h2 class="font-black text-center text-3xl mb-10 mt-10 text-white">
        Inicia Sesión en la Tienda Virtual FC-BCB
    </h2>
    <div class="md:flex md:justify-center md:gap md:items-center">
        <div class="md:w-6/12  p-5">
            <img class="rounded-lg" src="{{asset('img/login.png')}}" alt="Imagen de login usuario">
        </div>

        <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-xl">
            <form action="{{route('login')}}" method="POST" onsubmit="document.getElementById('submit').disabled=true; processFormData();" novalidate>
                @csrf
                @if (session('mensaje'))
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">
                        {{session('mensaje')}}
                    </p>
                @endif
                <div class="mb-5">

                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                        Correo Electronico
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        placeholder="Tu correo electronico de registro"
                        class="border p-3 w-full rounded-lg
                        @error('email')
                        border-red-500
                        @enderror"
                        value="{{old('email')}}"
                    />
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Contraseña
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Escribe Contraseña de Registro"
                        class="border p-3 w-full rounded-lg
                        @error('password')
                        border-red-500
                        @enderror"
                        value="{{old('password')}}"

                    />
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror

                    <!-- Mantener Sesión abierta -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                            <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                        </label>
                    </div>

                    <!-- <div class="flex justify-between my-5">
                        <a class="underline text-sm text-gray-600  hover:text-gray-900" href='{{ route('register') }}'>Crear Cuenta</a>
                        <a class="underline text-sm text-gray-600  hover:text-gray-900" href='{{ route('password.request') }}'>Olvidaste tu Password</a>
                    </div> -->

                    <input
                        id="submit"
                        type="submit"
                        value="Iniciar Sesion"
                        class="disabled:opacity-25 bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3"
                    />
                </div>
            </form>
        </div>
    </div>
@endsection

