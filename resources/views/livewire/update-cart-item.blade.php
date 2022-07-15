<div class="flex items-center" x-data>
    <button
    disabled
    x-bind:disabled="$wire.cantidad <= 1"
    wire:loading.attr="disabled"
    wire:target="decrement"
    wire:click="decrement"
    class="text-black font-bold border-2 border-black bg-white px-3 py-1 rounded hover:bg-indigo-900 hover:text-white">
        -
    </button>

    <span class="m-5">{{ $cantidad }}</span>

    <button
    x-bind:disabled="$wire.cantidad >= $wire.cantidad_stock"
    wire:loading.attr="disabled"
    wire:target="increment"
    wire:click="increment"
    class="text-black font-bold border-2 border-black bg-white px-3 py-1 rounded hover:bg-indigo-900 hover:text-white">
        +
    </button>
</div>
