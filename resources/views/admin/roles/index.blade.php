@extends('ui.nav')

@section('contenido-admin')
<!-- Listar RoLES -->
<div class="max-w-5xl">


    {{-- menu de navegacion para Listar y editar Roles --}}
    <div class="md:grid grid-cols-2 gap-1 my-4  sm:flex-grow">
        <div>
            <h2 class="p-2 bg-custom-100 text-white uppercase text-lg rounded-lg text-center font-bold border-2 ">Lista de Roles</h2>
        </div>
        <div class="ml-auto">
            <button class="p-2 mt-2 uppercase bg-sky-600 text-white font-bold hover:bg-sky-700 border border-gray-900  rounded-lg" onclick="location.href = '{{ route('admin.roles.create') }}'">
                <i class="fa-solid fa-plus"></i><span class="px-2">Nuevo Rol</span>
            </button>
        </div>
    </div>
    @if (session('info'))
    <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z" /></svg>
        <p class="uppercase">{{ session('info') }}</p>
    </div>
    @endif
    {{-- listado de roles --}}
    {{-- listado en tabla de usuarios --}}
    <div class="block w-full overflow-x-auto shadow-lg">
        <table class="items-center bg-transparent w-full border-collapse ">
            <thead>
                <tr>
                    <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                        ID
                    </th>
                    <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                        Role
                    </th>
                    <th colspan="2" class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">

                    </th>
                </tr>
            </thead>

            <tbody>

                @foreach ($roles as $role)
                <tr class="hover:bg-gray-100">
                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4 text-left text-blueGray-700 ">
                        {{-- {{ $user->id}} --}}
                        <div class="font-semibold text-center">{{ $role->id }}</div>
                    </th>
                    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4 ">
                        {{ $role->name }}
                    </td>
                    <td class="border-t-0 px-2 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-2">
                        <div class="flex justify-center text-red-500">
                            {{-- editar --}}
                            <p class="px-2">Editar</p>
                            <a href="{{ route('admin.roles.edit', $role->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                    <td class="border-t-0 px-2 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-2">
                        <form action="{{ route('admin.roles.destroy',$role->id) }}" method="POST" class="delete-product">
                            <div class="flex justify-center">
                                <button >
                                    @csrf
                                    @method('DELETE')
                                    <svg class="w-8 h-8 hover:text-blue-600 rounded-full hover:bg-gray-100 p-1"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- fin de listado de roles --}}
</div>

@endsection

@section('js')
    {{-- solicitud de confirmacion de eliminacion --}}
    <script type="text/javascript">


        $('.delete-product').submit(function(e){

        //previene el comportamiento por defecto del formulario
        e.preventDefault();

        Swal.fire({
        title: '¿Esta Seguro de Eliminar este ROL?',
        text: "¡Esta accion no es reversible!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, estoy Seguro',
        }).then((result) => {
            if (result.value) {
                this.submit();
            }
            })
        });
    </script>
@endsection
