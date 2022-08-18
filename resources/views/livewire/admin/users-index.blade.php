<div>
    <h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Lista de Usuarios </h2>
    {{-- tabla de usuarios --}}

    <!-- component -->
    <section class="py-1 bg-blueGray-50">
        <div class="w-full  mb-12 xl:mb-0 px-4 mx-auto mt-24">
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded ">

                {{-- barra de busqueda de usuarios --}}
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="relative">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-black dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input wire:model="search" class="block p-4 pl-10 w-full text-sm rounded-lg border border-gray-300 " placeholder="Escriba el nombre de Usuario">

                    </div>
                </div>
                {{-- fin de barra de busqueda de usuarios --}}

                {{-- verificamos que haya usuarios --}}
                @if ($users->count())
                {{-- listado en tabla de usuarios --}}
                <div class="block w-full overflow-x-auto">
                    <table class="items-center bg-transparent w-full border-collapse ">
                        <thead>
                            <tr>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    ID
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Nombre
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Email
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Editar el Rol
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($users as $user)
                            <tr>
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4 text-left text-blueGray-700 ">
                                    {{-- {{ $user->id}} --}}
                                    <div class="font-semibold text-center">{{ $user->id }}</div>
                                </th>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4 ">
                                    {{ $user->name }}
                                </td>
                                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                                    {{ $user->email }}
                                </td>
                                <td class="border-t-0 px-2 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-2">
                                    <div class="flex justify-center text-red-500">
                                        {{-- editar --}}
                                        <p class="px-2">Editar</p>
                                        <a href="{{ route('admin.users.edit', $user->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- paginacion --}}
                <div class="my-10">
                    {{ $users->links() }}
                </div>
                {{-- fin de listado de usuarios  --}}
                @else
                <h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">No hay registros</h2>
                @endif

            </div>
        </div>

    </section>
    {{-- fin de tabla de usuarios --}}
</div>
