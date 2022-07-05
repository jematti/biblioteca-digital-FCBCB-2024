<div x-data>
    <h4 class="text-gray-900 font-bold mb-2">Stock disponible: {{ $cantidad_stock }}</h4>

    <div class="flex items-center justify-start  ">
        <button
        disabled
        x-bind:disabled="$wire.cantidad <= 1"
        wire:loading.attr="dissabled"
        wire:target="decrement"
        wire:click="decrement"
        class="text-black font-bold border-2 border-black bg-white px-3 py-1 rounded hover:bg-indigo-900"
        >-</button>
        <span class="m-5">{{ $cantidad }}</span>
        <button
        x-bind:disabled="$wire.cantidad >= $wire.cantidad_stock"
        wire:loading.attr="dissabled"
        wire:target="increment"
        wire:click="increment"
        class="text-black font-bold border-2 border-black bg-white px-3 py-1 rounded hover:bg-indigo-900"
        >+</button>
    </div>
    <div>
        <button
        class="w-60 bg-custom-200 hover:bg-red-500 text-white font-bold py-2 px-4 rounded-lg">
            Agregar compra
        </button>
    </div>

</div>
