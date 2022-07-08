<div class="container py-8">
    @section('contenido')
        <section class="bg-white rounded-lg shadow-lg p-6 text-gray-600">
            <h1 class="text-xl font-bold mb-6">Carro de Compras</h1>
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
                                <a class="ml-6 cursor-pointer hover:text-red-600">
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
        </section>
    @endsection
</div>
