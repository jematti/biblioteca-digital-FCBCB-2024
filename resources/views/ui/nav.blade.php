@extends('layouts.app')

@section('contenido')

<div class="flex w-full bg-white">
    @if (auth()->user()->hasRole('usuario'))
        {{-- menu usuario --}}
        @can('nav.users')
        <div class="hidden md:flex w-72 flex-col space-y-2 border-r-2 border-gray-300 bg-white p-2" style="height: 90.5vh">
            {{-- <a href="{{ route('orders.index') }}" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span>Ordenes</span>
            </a> --}}
            <a href="{{ route('perfil.index') }}" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Editar Perfil</span>
            </a>
            <a href="{{ route('changepassword') }}" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
                <span>Cambiar Contraseña</span>
            </a>
            <a href="{{ route('notification') }}" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                <span>Notificaciones </span>
                <span class="ml-2 w-6 h-6 bg-red-500 hover:bg-red-700 rounded-full flex flex-col justify-center items-center text-sm font-bold text-white ">
                    {{ Auth::user()->unreadNotifications->count() }}
                </span> --}}
            </a>
        </div>
        @endcan
        {{-- fin de menu usuario --}}
    @else
        {{-- menu administrador --}}
        <div class="hidden md:flex w-72 flex-col space-y-2 border-r-2 border-gray-300  p-2" style="height: 90.5vh">

            @can('admin.users.index')
            <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-1 rounded-md px-2 py-1 hover:bg-gray-100 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg>
                <span>Usuarios</span>
            </a>
            @endcan
            @can('admin.roles.index')
            <a href="{{ route('admin.roles.index') }}" class="flex items-center space-x-1 rounded-md px-2 py-1 hover:bg-gray-100 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                </svg>
                <span>Roles</span>
            </a>
            @endcan

            @can('admin.orders.index')
            {{-- <a href="{{ route('notification') }}" class="flex items-center space-x-1 rounded-md px-2 py-1 hover:bg-gray-100 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                <span>Notificaciones </span>
                <span class="ml-2 w-6 h-6 bg-red-500 hover:bg-red-700 rounded-full flex flex-col justify-center items-center text-sm font-bold text-white ">
                    {{ Auth::user()->unreadNotifications->count() }}
                </span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="flex font-bold items-center space-x-1 rounded-md px-2 py-1 hover:bg-gray-100 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span>Pedidos</span>
            </a> --}}
            @endcan

            @can('admin.repositories.index')
            <a href="{{ route('repository.index') }}" class="flex items-center space-x-1 rounded-md px-2 py-1 hover:bg-gray-100 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
                <span>Repositorios</span>
            </a>
            @endcan
            @can('admin.repositories.create')
             <a href="{{ route('repository.create') }}" class="flex items-center space-x-1 rounded-md px-2 py-1 hover:bg-gray-100 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>Añadir Repositorio</span>
            </a>
            @endcan
            {{-- seccion de navegador lateral de productos --}}

            <div class="space-y-4 bg-white">
                <div x-data="{ activeAccordion: true }">
                    <h3>
                        <button @click="activeAccordion = !activeAccordion" class="flex items-center w-full p-2 text-white bg-custom-100 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <h2 class="px-2">Productos Tienda</h2>

                            <span :class="{ '-rotate-180': activeAccordion }" class="transition" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </button>
                    </h3>

                    <div x-show="activeAccordion" x-collapse class="mt-4">
                        @can('admin.products.index')
                        <a href="{{ route('products.index') }}" class="flex items-center space-x-1 rounded-md pl-5 py-1 hover:bg-gray-100 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <span>Lista de Productos</span>
                        </a>
                        @endcan

                        @can('admin.products.create')
                        <a href="{{ route('products.create') }}" class="flex items-center space-x-1 rounded-md pl-5 py-1 hover:bg-gray-100 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Añadir Producto</span>
                        </a>
                        @endcan

                        @can('admin.categories.index')
                        <a href="{{ route('category.index') }}" class="flex items-center space-x-1 rounded-md pl-5 py-1 hover:bg-gray-100 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
                            </svg>
                            <span>Categorias de Productos</span>
                        </a>
                        @endcan

                        @can('admin.categories.create')
                        <a href="{{ route('category.create') }}" class="flex items-center space-x-1 rounded-md pl-5 py-1 hover:bg-gray-100 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Añadir Categoria</span>
                        </a>
                        @endcan

                        @can('admin.authors.index')
                        <a href="{{ route('author.index') }}" class="flex items-center space-x-1 rounded-md pl-5 py-1 hover:bg-gray-100 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span>Autores</span>
                        </a>
                        @endcan

                        @can('admin.authors.create')
                        <a href="{{ route('author.create') }}" class="flex items-center space-x-1 rounded-md pl-5 py-1 hover:bg-gray-100 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Añadir Autor</span>
                        </a>
                        @endcan

                    </div>
                </div>
            </div>
            {{-- fin de seccion de productos --}}

            {{-- seccion reportes de navegador lateral --}}
            <div class="space-y-4 bg-white">
                <div x-data="{ activeAccordion: true}">
                    <h3>
                        @canany(['admin.reports.orders','admin.reports.sales'])
                        {{-- <button @click="activeAccordion = !activeAccordion" class="flex items-center w-full p-1 text-white bg-custom-100 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <h2 class="px-2">Reportes</h2>

                            <span :class="{ '-rotate-180': activeAccordion }" class="transition" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </button> --}}
                        @endcanany

                    </h3>

                    <div x-show="activeAccordion" x-collapse class="mt-4">
                        @can('admin.reports.orders')
                        {{-- <a href="{{ route('report_order.pdf') }}" class="flex items-center space-x-1 rounded-md pl-5 py-1 hover:bg-gray-100 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <span>Reporte Ordenes de Compra</span>
                        </a> --}}
                        @endcan
                        @can('admin.reports.sales')
                        {{-- <a href="{{ route('report_sale.pdf') }}" class="flex items-center space-x-1 rounded-md pl-5 py-1 hover:bg-gray-100 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <span>Reporte Ventas</span>
                        </a> --}}
                        @endcan
                    </div>
                </div>
            </div>
            {{-- fin de seccion de productos --}}

        </div>
        {{-- fin de modo administrador --}}
    @endif
    {{-- Seccion para introducir el contenido }} --}}
    <div class="w-full px-10 py-2">
        @yield('contenido-admin')
        @yield('contenido-perfil')
    </div>
    {{-- fin de seccion para introducir el contenido --}}
</div>



@endsection
