@extends('ui.nav')

@section('contenido-perfil')
            <h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Editar Perfil</h2>
                <form action="" method="POST" novalidate>
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
                            class="border p-3 w-full rounded-lg"
                            @error('name')
                                border-red-500
                            @enderror
                            value="{{auth()->user()->name}}"
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
                            class="border p-3 w-full rounded-lg"
                            @error('email')
                            border-red-500
                            @enderror
                            value="{{auth()->user()->email}}"
                        />
                        @error('email')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                        @enderror

                        <input
                            type="submit"
                            value="Actualizar Datos"
                            class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3 mt-5"
                        />
                    </div>
                </form>

                <h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Cambiar Contraseña</h2>

                <form action="{{ route('update-password') }}" method="POST" novalidate>
                    @csrf
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="mb-5">
                        <label for="old_password" class="mb-2 block uppercase text-gray-500 font-bold border">
                            Contraseña Actual
                        </label>
                        <input
                            id="old_password"
                            type="password"
                            name="old_password"
                            placeholder="Escribe Contraseña de Actual"
                            class="border p-3 w-full rounded-lg"
                            @error('old_password')
                            border-red-500
                            @enderror
                            value="{{old('old_password')}}"

                        />
                        @error('old_password')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                        @enderror

                        <label for="new_password" class="mb-2 block uppercase text-gray-500 font-bold">
                            Nueva Contraseña
                        </label>
                        <input
                            id="new_password"
                            type="password"
                            name="new_password"
                            placeholder="Escribe Contraseña de Registro"
                            class="border p-3 w-full rounded-lg"
                            @error('new_password')
                            border-red-500
                            @enderror
                            value="{{old('new_password')}}"

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

                        <input
                            type="submit"
                            value="Confirmar"
                            class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3 mt-5"
                        />
                    </div>
                </form>

@endsection
