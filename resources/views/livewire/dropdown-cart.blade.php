<div class="relative rounded-lg  px-1 pt-3 mx-1 mb-2" x-data="{dropdownMenu: false}" >
    <!-- Dropdown toggle button -->
    <button @click="dropdownMenu = ! dropdownMenu" class="flex items-center text-white " href="#" >
        <span class="relative inline-block cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            {{-- <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">99</span> --}}
            <span class="absolute top-0 right-0 inline-block w-2 h-2 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"></span>
        </span>
    </button >
    <!-- Dropdown list -->
    <div x-show="dropdownMenu" class="absolute right-0 py-2 mt-2 bg-white rounded-md shadow-xl w-64">
        <div class="p-5">
            <p class="font-semibold"> No tienes ningun producto agregado al carrito</p>
        </div>
        <a href="#" class="block px-4 py-2 text-sm  text-gray-700 hover:bg-gray-400 hover:text-white">
            Dropdown List 1
        </a>
        <a href="#" class="block px-4 py-2 text-sm  text-gray-700 hover:bg-gray-400 hover:text-white">
            Dropdown List 2
        </a>
        <a href="#" class="block px-4 py-2 text-sm  text-gray-700 hover:bg-gray-400 hover:text-white">
            Dropdown List 3
        </a>
    </div>


</div>


