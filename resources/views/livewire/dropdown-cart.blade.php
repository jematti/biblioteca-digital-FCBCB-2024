<div class="relative rounded-lg  px-1 pt-3 mx-1 mb-2" x-data="{dropdownMenu: false}">
    <!-- Dropdown toggle button -->
    <button @click="dropdownMenu = ! dropdownMenu" class="flex items-center text-white " href="#">
        <span class="relative inline-block cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>

            @if (Cart::count())
                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{ Cart::count() }}</span>
            @else
                <span class="absolute top-0 right-0 inline-block w-2 h-2 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"></span>
            @endif
        </span>
    </button>
    <!-- Dropdown list -->
    <div x-show="dropdownMenu" class="absolute right-0 py-2 mt-2 bg-white rounded-md shadow-xl w-72">
        <ul>
            @forelse (Cart::content() as $item)

            <li class="flex border-b border-gray-200">
                <img src="{{ asset('uploads').'/'.$item->options->imagen}}" alt="imagen de busqueda" class="w-16 h-12 m-2 object-cover">
                <article class="flex-1">
                    <h1 class="text-lg font-semibold">{{ $item->name}}</h1>
                    <p class="text-base  text-gray-500 font-medium">Cant: {{ $item->qty}}</p>
                    <p class="text-base  text-gray-500 font-medium">Bs: {{ $item->price}}</p>
                </article>
            </li>

            @empty
            <div class="p-5">
                <p class="font-semibold"> No tienes ningun producto agregado al carrito</p>
            </div>
            @endforelse
        </ul>
        @if (Cart::count())
        <div class="p-2">
            <p class="text-lh text-gray-700 mb-1" ><span class="font-bold">Total: </span>Bs. {{ Cart::subtotal() }}</p>
            <button  class="w-full bg-custom-200 hover:bg-red-500 text-white font-bold py-2 px-4 rounded-lg">
                Ir al carrito de compras
            </button>
        </div>
        @endif


    </div>


</div>
