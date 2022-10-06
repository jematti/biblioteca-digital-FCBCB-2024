@extends('ui.nav')

@section('contenido-admin')
    <!-- Editar rol -->
    <div class="max-w-5xl">

        <h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Editar Rol</h2>
        @if (session('info'))
            <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path
                        d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z" />
                </svg>
                <p class="uppercase">{{ session('info') }}</p>
            </div>
        @endif

        <div class="m-5 shadow-lg p-5">

            {{-- formulario para agregar categoria --}}
            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" class="actualizar" novalidate>

                @method('PUT')
                @csrf
                <div class="mb-5">
                    <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">
                        Nombre
                    </label>
                    <input id="name" type="text" name="name" placeholder="Ingrese el nombre del Rol"
                        class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"
                        value="{{ $role->name }}" />
                    @error('name')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{ $message }}</p>
                    @enderror

                    <h2 class="font-bold my-2">Lista de Permisos </h2>
                    @foreach ($permissions as $permission)
                        @if ($permission->description != null)
                            <div>
                                <label>
                                    <input  type="checkbox" name="permissions[]" value="{{$permission->id}}"
                                        class="font-semibold"
                                        {{ $role->permissions->pluck('name')->contains($permission->name) ? 'checked' : '' }}>
                                    {{ $permission->description }}
                                </label>
                            </div>
                        @endif
                    @endforeach
                    <input type="submit" value="Editar Rol"
                        class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3 mt-5" />
                </div>
            </form>

        </div>

    </div>
@endsection
