@extends('layouts.app')



@section('contenido')
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />

    <!-- page -->
    <main class="min-h-screen w-full bg-gray-100 text-gray-700" x-data="layout">
        <div class="flex w-full">
            <!-- aside -->
            <aside class="flex w-72 flex-col space-y-2 border-r-2 border-gray-200 bg-white p-2" style="height: 90.5vh"
                x-show="asideOpen">
                <a href="#" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="bx bx-home"></i></span>
                    <span>Principal6</span>
                </a>

                <a href="#" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="bx bx-cart"></i></span>
                    <span>Carro</span>
                </a>

                <a href="#" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="bx bx-shopping-bag"></i></span>
                    <span>Lista de Compras</span>
                </a>

                <a href="#" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="bx bx-heart"></i></span>
                    <span>Lista de Favoritos</span>
                </a>

                <a href="#" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="bx bx-user"></i></span>
                    <span>Perfil</span>
                </a>
            </aside>

            <!-- Editar Perfil -->
            <div class="w-1/2 p-4">
                <h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Editar Perfil</h2>
                <form action="#" method="POST" novalidate>
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
                        <label for="ci" class="mb-2 block uppercase text-gray-500 font-bold">
                            Carnet de Identidad
                        </label>
                        <input
                            id="ci"
                            type="text"
                            name="ci"
                            placeholder="Tu Nro de Carnet de Identidad"
                            class="border p-3 w-full rounded-lg"
                            @error('ci')
                            border-red-500
                            @enderror
                            value="{{auth()->user()->ci}}"
                        />
                        @error('ci')
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

                <form action="#" method="POST" novalidate>
                    @csrf
                    <div class="mb-5">
                        <label for="password" class="mb-2 block uppercase text-gray-500 font-bold border">
                            Contraseña Actual
                        </label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Escribe Contraseña de Registro"
                            class="border p-3 w-full rounded-lg"
                            @error('password')
                            border-red-500
                            @enderror
                            value="{{old('password')}}"

                        />
                        @error('password')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                        @enderror

                        <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                            Nueva Contraseña
                        </label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Escribe Contraseña de Registro"
                            class="border p-3 w-full rounded-lg"
                            @error('password')
                            border-red-500
                            @enderror
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

                        <input
                            type="submit"
                            value="Confirmar"
                            class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3 mt-5"
                        />
                    </div>
                </form>

            </div>
        </div>
    </main>

@endsection
