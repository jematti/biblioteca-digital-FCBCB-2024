<div class="flex-1 flex justify-center px-2 lg:ml-6 lg:justify-start " x-data>
    <div class="max-w-lg w-full lg:max-w-2xl ">
        <label for="search" class="sr-only">Search </label>
        <form action={{  route('search')}} class="relative" autocomplete="off">
            <button class="absolute inset-y-0 left-0 pl-3 flex items-center ">
                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <input wire:model="search_main" name="product_search" type="text" placeholder="Buscar libro por palabra clave / titulo / autor / ISBN  " class="z-50 block w-full pl-10 pr-3 py-2 h-12 border border-transparent rounded-md leading-5 bg-white text-gray-300 placeholder-gray-400 focus:outline-none focus:bg-white focus:text-gray-900 sm:text-sm transition duration-150 ease-in-out" placeholder="Search">
        </form>
    </div>

    {{-- listado de opciones de busqueda --}}
    <div class="absolute max-w-lg w-full lg:max-w-2xl mt-12 hidden" :class="{ 'hidden' : !$wire.open }" @click.away="$wire.open = false">
        <div class="bg-white rounded-lg shadow-lg mt-1">
            <div class="px-4 py-3">
                {{-- listar datos del la consulta del controlador SearchMain --}}
                @forelse ($products as $product)
                <a href="{{ route('products.show', $product) }}" class="flex">
                    <img src="{{ asset('uploads').'/'.$product->imagen}}" alt="imagen de busqueda" class="w-16 h-12 object-cover">
                    <div class="ml-4 ">
                        <p class="text-base font-semibold">{{ $product->titulo }}</p>
                        <p class="text-sm  text-gray-500 font-medium">{{ $product->nombre_autor}}</p>
                    </div>
                </a>
                <hr>
                @empty
                <p class="text-lg font-semibold">No existe registro con los parametros especificados</p>
                @endforelse
            </div>
        </div>
    </div>
    {{-- fin listado --}}
</div>
