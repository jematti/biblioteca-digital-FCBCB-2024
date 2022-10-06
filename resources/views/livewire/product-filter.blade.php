<div>
    <div class="bg-white rounded-lg shadow-lg mb-6">
        <div class="px-6 py-2 flex justify-between items-center">
            <h1 class="font-semibold text-gray-700 uppercase">Filtro de Busqueda</h1>

            <div class="md:block grid grid-cols-2 border border-gray-200 divide-x divide-gray-200 text-gray-500">
                <i class="fas fa-border-all p-3 cursor-pointer {{ $view == 'grid' ? 'text-orange-500' : '' }}"
                    wire:click="$set('view', 'grid')"></i>
                <i class="fas fa-th-list p-3 cursor-pointer {{ $view == 'list' ? 'text-orange-500' : '' }}"
                    wire:click="$set('view', 'list')"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mx-5">
        {{-- sección de filtros --}}

        <aside>
            <button
                class="w-full px-1 py-2 my-5 rounded text-center text-lg bg-orange-500 font-medium text-white leading-5 hover:bg-orange-400"
                wire:click="limpiar">
                Reiniciar filtros de Busqueda
            </button>
            {{-- lista de categorias --}}
            <h2 class="font-semibold text-center mb-2">Categorías</h2>
            <ul class="divide-y divide-gray-200">
                @foreach ($categories as $categoria)
                    <li class="py-2 text-sm">
                        <a class="cursor-pointer
                           hover:font-bold capitalize
                           {{ $category == $categoria->id ? 'text-white bg-orange-400 rounded-lg p-1 font-semibold' : '' }}"
                            wire:click="$set('category', '{{ $categoria->id }}')">
                            {{ $categoria->nombre_categoria }}
                        </a>
                    </li>
                @endforeach
            </ul>
            {{-- lista de repositorios --}}
            <h2 class="font-semibold text-center mt-4 mb-2">Repositorios</h2>
            <ul class="divide-y divide-gray-200">
                @foreach ($repositories as $repositorio)
                    <li class="py-2 text-sm">
                        <a class="cursor-pointer hover:font-bold  capitalize {{ $repository == $repositorio->id ? 'text-white bg-orange-400 rounded-lg p-1 font-semibold' : '' }}"
                            wire:click="$set('repository', '{{ $repositorio->id }}')">
                            {{ $repositorio->nombre_repositorio }}
                        </a>
                    </li>
                @endforeach
            </ul>

            {{-- Precios por Fechas Novedades --}}

            <ul class="divide-y divide-gray-200">
                {{-- ascendente --}}
                <li class="py-2 text-sm">
                    <a class="cursor-pointer
                           hover:font-bold capitalize
                           {{ $novedades == 'true' ? 'text-white bg-orange-400 rounded-lg p-1 font-semibold' : '' }}"
                        wire:click="$set('novedades', 'true')">
                        Novedades
                    </a>
                </li>
            </ul>
            {{-- lista ascendente  y descendente --}}
            <h2 class="font-semibold text-center mt-4 mb-2">Precios</h2>
            <ul class="divide-y divide-gray-200">
                {{-- ascendente --}}
                <li class="py-2 text-sm">
                    <a class="cursor-pointer
                           hover:font-bold capitalize
                           {{ $precio_asc == 'true' ? 'text-white bg-orange-400 rounded-lg p-1 font-semibold' : '' }}"
                        wire:click="$set('precio_asc', 'true')">
                        precio ascendente
                    </a>
                </li>
                {{-- descendente --}}
                <li class="py-2 text-sm">
                    <a class="cursor-pointer
                           hover:font-bold capitalize
                           {{ $precio_desc == 'true' ? 'text-white bg-orange-400 rounded-lg p-1 font-semibold' : '' }}"
                        wire:click="$set('precio_desc', 'true')">
                        precio descendente
                    </a>
                </li>
            </ul>

            {{-- lista de autores --}}
            <h2 class="font-semibold text-center mt-4 mb-2">Autores</h2>
            <ul class="divide-y divide-gray-200">
                @foreach ($authors as $autor)
                    <li class="py-2 text-sm">
                        <a class="cursor-pointer hover:font-bold  capitalize {{ $author == $autor->id ? 'text-white bg-orange-400 rounded-lg p-1 font-semibold' : '' }}"
                            wire:click="$set('author', '{{ $autor->id }}')">
                            {{ $autor->nombre_autor }}
                        </a>
                    </li>
                @endforeach
            </ul>


        </aside>
        {{-- fin sección de filtros --}}

        {{-- listado de productos --}}
        <div class="md:col-span-2 lg:col-span-4">
            @if ($view == 'grid')

                <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse ($products as $product)
                        <li class="bg-white rounded-lg shadow">
                            <div>
                                <a href='{{ route('products.show', $product) }}'>
                                    <figure>
                                        <img class="h-56 w-full object-scale-down object-center"
                                            src="{{ asset('uploads') . '/' . $product->imagen }}" alt="">
                                    </figure>

                                    <div class="py-4 px-6 mx-20 md:mx-2">
                                        <h1 class="text-lg font-semibold">
                                            <a href="{{ route('products.show', $product) }}">
                                                {{ $product->titulo }}
                                            </a>
                                        </h1>

                                        <p class="font-bold text-trueGray-700">Bs. {{ $product->precio }}</p>

                                        <button onclick="location.href ='{{ route('products.show', $product) }}' "
                                            name="add" type="button"
                                            class="flex items-center w-full justify-center p-2 sm:px-5 sm:py-3 sm:mt-2 text-white bg-custom-500  hover:bg-orange-400 focus:outline-none  rounded-lg">
                                            <span class="text-sm font-medium">
                                                Ver Descripción
                                            </span>

                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1.5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>

                                        </button>
                                    </div>
                                </a>
                            </div>
                        </li>

                    @empty
                        <li class="md:col-span-2 lg:col-span-4">
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                                role="alert">
                                <strong class="font-bold">Upss!</strong>
                                <span class="block sm:inline">No existe ningún producto con ese filtro.</span>
                            </div>
                        </li>
                    @endforelse
                </ul>
            @else
                <ul>
                    @forelse ($products as $product)
                        <li class="bg-white rounded-lg shadow">
                            <div class="flex">
                                <a href='{{ route('products.show', $product) }}'>
                                    <figure>
                                        <img class="h-48 w-56 object-scale-down object-center"
                                            src="{{ asset('uploads') . '/' . $product->imagen }}" alt="">
                                    </figure>

                                    <div class="flex-1 py-4 px-6 flex flex-col">
                                        <div class="flex flex-wrap">

                                            <div class="flex object-center ">
                                                <div>
                                                    <h1 class="text-xl font-semibold">
                                                        <a href="{{ route('products.show', $product) }}">
                                                            {{ $product->titulo }}
                                                        </a>
                                                    </h1>
                                                </div>
                                                <div>
                                                    <p class="font-bold text-xl md:ml-56 ml-2">Bs. {{ $product->precio }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="md:w-full w-56">
                                                <p x-data="{ isCollapsed: false, maxLength: 350, originalContent: '', content: '' }" x-init="originalContent = $el.firstElementChild.textContent.trim(); content = originalContent.slice(0, maxLength)" class="text-justify mr-2">
                                                    <span x-text="isCollapsed ? originalContent : content">
                                                        {{ $product->resumen }}
                                                    </span>
                                                    ...
                                                    <button @click="isCollapsed = !isCollapsed" x-show="originalContent.length > maxLength" x-text="isCollapsed ? 'Ver menos' : 'Ver mas'" class="font-semibold text-gray-500 underline"></button>
                                                </p>
                                            </div>

                                        </div>

                                        <div class="mt-auto mb-5 md:w-full w-56">
                                            <button onclick="location.href ='{{ route('products.show', $product) }}' "
                                                name="add" type="button"
                                                class="flex items-center w-full justify-center p-2 sm:px-5 sm:py-3 sm:mt-2 text-white bg-custom-500  hover:bg-orange-400 focus:outline-none  rounded-lg">
                                                <span class="text-lg font-medium">
                                                    Ver Descripción
                                                </span>

                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </li>

                    @empty

                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">Upss!</strong>
                            <span class="block sm:inline">No existe ningún producto con ese filtro.</span>
                        </div>
                    @endforelse
                </ul>


            @endif

            <div class="mt-4">
                {{$products->links()}}
            </div>
        </div>
        {{-- fin de listado de productos --}}

    </div>
</div>
