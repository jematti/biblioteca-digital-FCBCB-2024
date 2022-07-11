<div class="container py-8 bg-gray-100 p-10">

    <section class="bg-white rounded-lg shadow-lg p-6 text-gray-600">
        <h1 class="text-xl font-bold mb-6">Carro de Compras</h1>
        @if (Cart::count())
        <table class="table-auto w-full ">
            <thead>
                <tr>
                    <th></th>
                    <th>Precio</th>
                    <th>Cant</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                @foreach (Cart::content() as $item )
                <tr>
                    <td class="text-center">
                        <div class="flex ">
                            <img src="{{ asset('uploads').'/'.$item->options->imagen}}" alt="imagen de busqueda" class="w-20 h-15 mr-4 object-cover">
                            <div>
                                <p class="font-bold">{{ $item->name }}</p>
                            </div>
                        </div>
                    </td>

                    <td class="text-center">
                        <span>Bs. {{ $item->price }}</span>
                        <a class="ml-6 cursor-pointer hover:text-red-600" wire:click="delete('{{ $item->rowId }}')" wire:loading.class="text-red-600 opacity-25" wire:target="delete('{{ $item->rowId }}')">

                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>

                    <td>
                        <div class="flex justify-center">
                            @livewire('update-cart-item', ['rowId' => $item->rowId], key($item->rowId))
                        </div>
                    </td>

                    <td class="text-center">
                        Bs. {{ $item->price * $item->qty }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a wire:click="destroy" class="text-sm cursor-pointer hover:underline inline-block mt-5 pl-5">
            <i class="fas fa-trash"></i>
            Borrar Carrito de Compras
        </a>

        @else
        <div class="flex flex-col items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-11 w-11" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <p class="text-lg text-gray-700 font-semibold mt-4">TU CARRO DE COMPRAS ESTA VACÍO</p>
            <button onclick="location.href='{{ route('home') }}'" class="px-16 bg-red-500 hover:bg-red-400 text-white font-bold py-2 mt-2 rounded-lg">
                Ir al inicio
            </button>
        </div>
        @endif
    </section>

    @if (Cart::count())
    <div class="bg-white rounded-lg shadow-lg px-6 py-4 my-4">
        <div class="flex justify-between items-center">

            <p class="text-gray-700">
                <span class="font-bold text-lg">Total</span>
                Bs. {{ Cart::subtotal() }}
            </p>

            <a href="{{ route('orderscreate.index') }}" class="px-16 bg-red-500 hover:bg-red-400 text-white font-bold py-2 mt-2 rounded-lg">
                Continuar
            </a>
        </div>
    </div>
    @endif

</div>
