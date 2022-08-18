<div>
    <div class="bg-white ">

        <div class="max-w-full  px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex justify-center items-center text-lg font-bold">
                Estado del pedido:
                @switch($order->estado)
                @case(1)
                   <span class="font-bold p-1  mx-2 text-white  rounded-lg bg-orange-500">Pendiente</span>
                @break

                @case(2)
                   <span class="font-bold p-1  mx-2 text-white rounded-lg bg-gray-500">Recibido</span>
                @break

                @case(3)
                    <span class="font-bold p-1 mx-2 text-white rounded-lg bg-yellow-500">Enviado</span>
                @break

                @case(4)
                    <span class="font-bold p-1 mx-2 text-white rounded-lg bg-blue-500">Entregado</span>
                @break

                @case(5)
                    <span class="font-bold p-1 mx-2 text-white rounded-lg bg-red-500">Anulado</span>
                @break
                @default

                @endswitch
            </div>
            <div class="bg-white flex items-center rounded-lg shadow-lg px-6 py-6 mb-6">

                {{-- Estado del pedido --}}
                <div class="relative">
                    <div class="{{ $order->estado >= 2 && $order->estado != 5 ? 'bg-blue-400' : 'bg-gray-400'}} rounded-full h-12 w-12  flex items-center justify-center">
                        <i class="fas fa-check text-white"></i>
                    </div>

                    <div class="absolute -left-1.5 mt-0.5">
                        <p>Recibido</p>
                    </div>
                </div>

                <div class="{{ $order->estado >= 3 && $order->estado != 5 ? 'bg-blue-400' : 'bg-gray-400'}} h-1 flex-1 mx-2"></div>

                <div class="relative">
                    <div class="{{ $order->estado >= 3 && $order->estado != 5 ? 'bg-blue-400' : 'bg-gray-400'}} rounded-full h-12 w-12 flex items-center justify-center">
                        <i class="fas fa-truck text-white"></i>
                    </div>

                    <div class="absolute -left-1 mt-0.5">
                        <p>Enviado</p>
                    </div>
                </div>

                <div class="{{ $order->estado >= 4 && $order->estado != 5 ? 'bg-blue-400' : 'bg-gray-400'}} h-1 flex-1 mx-2"></div>

                <div class="relative">
                    <div class="{{ $order->estado >= 4 && $order->estado != 5 ? 'bg-blue-400' : 'bg-gray-400'}} rounded-full h-12 w-12 flex items-center justify-center">
                        <i class="fas fa-check text-white"></i>
                    </div>

                    <div class="absolute -left-2 mt-0.5">
                        <p>Entregado</p>
                    </div>
                </div>

                <div class="relative ml-10">
                    <div class="{{ $order->estado == 5 ? 'bg-red-500' : 'bg-gray-400'}} rounded-full h-12 w-12 flex items-center justify-center">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>

                    <div class="absolute -left-2 mt-0.5">
                        <p>Anulado</p>
                    </div>
                </div>

                <div class="relative ml-6">
                    <div class="{{ $order->estado == 1 ? 'bg-orange-400' : 'bg-gray-400'}} rounded-full h-12 w-12 flex items-center justify-center">
                        <i class="fas fa-business-time text-white"></i>
                    </div>

                    <div class="absolute -left-2 mt-0.5">
                        <p>Pendiente</p>
                    </div>
                </div>

                {{-- fin del estado de pedido --}}

            </div>

            {{-- cambiar el estado de la orden --}}
            <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6 border-2 border-blue-500">
                <p class="text-gray-700 uppercase font-bold">
                    <span class="font-semibold">Numero de Orden:</span>
                    {{ $order->id }}
                </p>
                <form wire:submit.prevent="actualizar">
                    {{-- seccion de cambiar el estado de la orden --}}
                    <div class="flex space-x-3 mt-2">
                        <label for="estado">
                            <input wire:model="estado" type="radio" name="estado" value="2" class="mr-2">
                            RECIBIDO
                        </label>

                        <label for="estado">
                            <input wire:model="estado" type="radio" name="estado" value="3" class="mr-2">
                            ENVIADO
                        </label>

                        <label for="estado">
                            <input wire:model="estado" type="radio" name="estado" value="4" class="mr-2">
                            ENTREGADO
                        </label>

                        <label for="estado">
                            <input wire:model="estado" type="radio" name="estado" value="5" class="mr-2">
                            ANULADO
                        </label>

                        <label for="estado">
                            <input wire:model="estado" type="radio" name="estado" value="1" class="mr-2">
                            PENDIENTE
                        </label>
                    </div>
                    {{-- fin de seccion de cambiar el estado de la orden --}}

                    {{-- seccion decaja de texto de observacion --}}
                    <div class="mt-3">
                        <div class="w-full ">
                            <label class="mb-2 block uppercase text-red-500 font-semibold" for="observacion">
                                Observación
                            </label>
                            <textarea
                            class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none"
                            id="observacion"
                            name="observacion"
                            wire:model.defer="observacion"
                            placeholder="Motivo de la Observacion/Anulación de la Orden"
                            @error('observacion')
                            border-red-500
                            @enderror
                            rows="3">
                            {{ $observacion}}
                            </textarea>
                            @error('observacion')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    {{-- fin de seccion de caja  de texto --}}

                    <div class="flex mt-2 ">
                        <button class="ml-auto bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">
                            Actualizar orden
                        </button>
                    </div>
                </form>
            </div>

            {{-- seccion de facturacion y verificacion de pago --}}
            <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6 border-2 ">
                <div class="grid grid-cols-2 gap-6">
                    {{-- seccion de datos para facturar --}}
                    <div>
                        <p class="text-lg font-semibold uppercase text-red-500">Datos para la Factura: </p>
                        <p class="text-base font-semibold">Nombre/Razon Social: {{ $order->nombre_factura}}</p>
                        <p class="text-base font-semibold">NIT : {{ $order->nit_factura}}</p>
                        {{-- fin de seccion de datos para factura --}}

                        {{-- estado de factura --}}
                        <p class="text-base font-semibold mb-2"> Estado de Facturación :
                            @if($order->estado_facturacion == 100)
                            <span class="bg-red-500  rounded-lg text-white p-1">NO FACTURADO</span>
                            @else
                            <span class="bg-green-400 rounded-lg text-white p-1">FACTURADO</span>
                            @endif
                        </p>
                        <hr>
                        {{-- proceso de facturacion --}}
                        <form wire:submit.prevent="facturacion">
                            <div class="my-2">
                                <label class="mb-1 text-base font-semibold" for="nro_factura">
                                    Nro de Factura
                                </label>

                                <input type="text" wire:model.defer="nro_factura" class="rounded-lg block shadow-sm w-full text-sm p-2.5 border border-gray-500" placeholder="Ingrese el nombre completo" id="nro_factura" name="nro_factura" @error('nro_factura') border-red-500 @enderror value="{{$nro_factura}}" />

                                @error('nro_factura')
                                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                                @enderror
                            </div>


                            <div class="flex mt-2 ">
                                <button class="ml-auto bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">
                                    Añadir Nro de Factura
                                </button>
                            </div>
                        </form>
                    </div>
                    {{-- fin de proceso de facturacion --}}

                    {{-- seccion de verificacion de comprobante de pago --}}
                    <div class="ml-2 pl-2 border-l-2">
                        <p class="text-lg font-semibold text-red-500 uppercase">
                            Información de Pago
                        </p>
                        <p class="text-base font-semibold">
                            Subtotal: {{ $order->total - $order->costo_envio }} Bs
                        </p>
                        <p class="text-base font-semibold">
                            Envio: {{ $order->costo_envio }} Bs
                        </p>

                        <p class="text-xl font-semibold">
                            Total: {{ $order->total }} Bs
                        </p>
                        <hr>
                        <div class="flex flex-col ">

                            <a class=" bg-sky-500 hover:bg-sky-700 text-center text-white font-bold py-2 px-4 my-2 rounded-lg" href="{{ asset('depositos').'/'.$order->imagen_deposito}}" target="_blank" rel="noopener noreferrer">
                                Ver deposito
                            </a>
                            <a class=" bg-sky-500 hover:bg-sky-700 text-center text-white font-bold py-2 px-4 my-2 rounded-lg" href="{{ route('orders.download',$order->imagen_deposito)}}" target="_blank" rel="noopener noreferrer">
                                Descargar deposito
                            </a>
                        </div>
                    </div>
                    {{-- fin de seccion de comprobante de pago --}}
                </div>
            </div>
            {{-- fin de seccion de facturacion y verificacion de pago --}}

            {{-- Seccion de datos de contacto --}}
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-lg font-semibold uppercase">Envío</p>
                        @if ($order->tipo_envio == 2)
                        <p class="text-base">Los Libros deben ser recogidos en tienda</p>
                        {{-- direccion de la tiendas donde se ubican los libros --}}
                        <p class="text-base">Calle falsa 123</p>
                        @else
                        {{-- direccion donde se enviaran los pedidos --}}
                        <p class="text-base">Los Libros seran envíados a:</p>
                        <p class="text-lg font-semibold">{{ $order->direccion }}</p>
                        @endif
                    </div>

                    <div>
                        <p class="text-lg font-semibold uppercase">Datos de Contacto</p>
                        <p class="text-base">Persona que recibira el libro: {{ $order->nombre_contacto }}</p>
                        <p class="text-base">Correo: {{ $order->correo_contacto }}</p>
                        <p class="text-base">Telefono: {{ $order->telefono_contacto }}</p>

                    </div>
                </div>
            </div>
            {{-- fin de seccion de datos de contacto --}}

            {{-- seccion de inventario --}}
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <div class="block w-full overflow-x-auto">
                    <table class="items-center bg-transparent w-full border-collapse ">
                        <thead>
                            <tr>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Titulo del Libro
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Ubicacion del libro
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Precio
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Nro. Ejemplares <br> Solicitados
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Stock Disponible
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Stock Actualizado
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Total
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Revision
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @foreach ($items as $item)
                            <tr>
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4 text-left text-blueGray-700 ">
                                    <div>
                                        <img class="h-32 object-cover mr-4" src="{{ asset('uploads').'/'.$item->options->imagen}}" alt="imagen de portada de libro">

                                        <article>
                                            <h1 class="font-bold">{{ $item->name }}</h1>
                                        </article>
                                    </div>
                                </th>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4 ">
                                    {{ $item->options->ubicacion}}
                                </td>
                                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                                    {{ $item->price }}
                                </td>
                                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                                    {{ $item->qty }}
                                </td>
                                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                                    {{ $item->options->cantidad_libro }}
                                </td>
                                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                                    {{ ($item->options->cantidad_libro) - ($item->qty) }}
                                </td>
                                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                                    {{ $item->price * $item->qty }} Bs
                                </td>
                                <td class="border-t-0 px-2 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-2">
                                    <div class="flex justify-center text-red-500">
                                        {{-- editar --}}
                                        <p class="px-2">Editar</p>
                                        <a href="#">
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
            </div>
            {{-- fin de seccion de inventario --}}


        </div>
    </div>
</div>
