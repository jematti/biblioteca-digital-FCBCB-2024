@extends('layouts.app')


@section('contenido')
<h2 class="font-black text-center text-3xl mb-10 mt-10 text-white">
    Regístrate en la Tienda Virtual FC-BCB
</h2>
    <div class="md:flex md:justify-center md:gap md:items-center">
        <div class="md:w-6/12  p-5">
            <img src="{{asset('img/register.jpg')}}" alt="Imagen de registro usuario">
        </div>

        <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-xl">
            <form action="{{route('register')}}" method="POST"  onsubmit="document.getElementById('submit').disabled=true; processFormData();" novalidate>
                @csrf
                <div class="mb-5">
                    <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">
                        Nombre
                    </label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        placeholder="Tu Nombre Completo"
                        class="border p-3 w-full rounded-lg
                        @error('name')
                            border-red-500
                        @enderror"
                        value="{{old('name')}}"
                    />
                    @error('name')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
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
                    <label for="password_confirmation" class="mb-2 block uppercase text-gray-500 font-bold">
                       Repite Tu Contraseña
                    </label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        placeholder="Repite Tu Contraseña"
                        class="border p-3 w-full rounded-lg"
                    />

                    <div class="flex justify-between my-5">
                        <a class="underline text-sm text-gray-600  hover:text-gray-900" href='{{ route('login') }}'>Iniciar Sesión</a>
                        <a class="underline text-sm text-gray-600  hover:text-gray-900" href='{{ route('password.request') }}'>Olvidaste tu Password</a>
                    </div>

                    <input
                        id="submit"
                        type="submit"
                        value="Crear Cuenta"
                        class="disabled:opacity-25 bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3 mt-5"
                    />
                </div>
            </form>
        </div>
    </div>
@endsection
