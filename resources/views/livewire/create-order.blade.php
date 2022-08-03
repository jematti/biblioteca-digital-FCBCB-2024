<div>
    <div class="grid lg:grid-flow-col grid-rows-2 lg:grid-cols-3 md:grid-cols-1 gap-4 p-5 bg-gray-300 ">
        {{-- formulario de datos personales --}}
        <div class="shadow-lg text-lg text-left bg-white py-5 rounded-lg row-span-2">
            <div class="px-5">
                <p class="my-2 font-bold text-lg text-black">1) Llena tus datos </p>
                <hr>

                    <div class="mb-2">
                        <label class="mb-1 text-base " for="nombre_contacto">
                            Nombre Completo
                        </label>

                        <input
                        type="text"
                        wire:model.defer="nombre_contacto"
                        class="rounded-lg block shadow-sm w-full text-sm p-2.5 border border-gray-500"
                        placeholder="Ingrese el nombre completo"
                        id="nombre_contacto"
                        name="nombre_contacto"
                        @error('nombre_contacto')
                        border-red-500
                        @enderror
                        value="{{old('nombre_contacto')}}"
                         />

                        @error('nombre_contacto')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="mb-1 text-base " for="correo_contacto">
                         Correo electronico
                        </label>

                        <input
                        type="email"
                        wire:model.defer="correo_contacto"
                        class="rounded-lg shadow-sm w-full text-sm p-2.5  border border-gray-500"
                        placeholder="Ingrese el su correo actual"
                        id="correo_contacto"
                        name="correo_contacto"
                        @error('correo_contacto')
                        border-red-500
                        @enderror
                        value="{{old('correo_contacto')}}"
                         />

                        @error('correo_contacto')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="mb-1 text-base " for="telefono_contacto">
                         Telefono/Celular
                        </label>

                        <input
                        type="text"
                        wire:model.defer="telefono_contacto"
                        class="rounded-lg shadow-sm w-full text-sm p-2.5  border border-gray-500"
                        placeholder="Ingrese el su Telefono/Celular vigente"
                        id="telefono_contacto"
                        name="telefono_contacto"
                        @error('telefono_contacto')
                        border-red-500
                        @enderror
                        value="{{old('telefono_contacto')}}"
                         />

                        @error('telefono_contacto')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                        @enderror
                    </div>

                    {{-- dato para la factura --}}

                    <p class="mb-2 mt-10 font-bold text-lg text-black">2) Datos para la Factura </p>
                    <hr>
                    <div class="mb-2">
                        <label class="mb-1 text-base " for="factura">
                         Nombre y NIT para la factura
                        </label>
                        <textarea
                        wire:model.defer="factura"
                        class="
                            form-control
                            block
                            w-full
                            px-3
                            py-1.5
                            text-base
                            font-normal
                            text-gray-700
                            bg-white bg-clip-padding
                            border border-solid border-gray-300
                            rounded
                            transition
                            ease-in-out
                            m-0
                            focus:text-neutral-700 focus:bg-white focus:border-gray-600 focus:outline-none
                        "
                        id="factura"
                        name="factura"
                        placeholder="Señor(es): ......NIT...."
                        @error('factura')
                        border-red-500
                        @enderror
                        value="{{old('factura')}}"
                        rows="3"
                        ></textarea>

                        @error('factura')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                        @enderror

                    </div>

            </div>
        </div>


        {{-- formulario de metodo de pago --}}
        <div class="shadow-lg bg-white text-lg  p-2 rounded-lg"  x-data="{tipo_pago: @entangle('tipo_pago')}" >
            <p class="my-3 font-bold text-lg text-black">3) Elige Método de Pago </p>
             <div>
                <label class=" px-3 py-2 flex items-center">
                    <input
                     x-model="tipo_pago"
                     { old('tipo_pago.1')=="1" ? 'checked='.'"'.'checked'.'"' : '' } }
                     type="radio"
                     value="1"
                     name="tipo_pago[1]"
                     class="text-gray-600">
                     @error('tipo_pago')
                         <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                     @enderror

                    <span class="ml-2 text-gray-700">
                        Lector de Qr
                    </span>
                </label>
            </div>

            <div class="px-6 pb-6 mt-2 hidden"  :class="{'hidden': tipo_pago != 1 }" >
                <div class="flex items-center">
                    <p class="font-semibold text-lg">Realiza pagos mediante el codigo QR "BANCO UNION"</p>
                    <img class="rounded-xl h-24 px-2 align-middle w-24 " alt="codigo QR aplicacion wayruru" src="{{ asset('img/app-wayruru-qr.png')}}">
                </div>
           </div>

            <div>
                <label class=" px-3 py-2 flex items-center">
                    <input
                    x-model="tipo_pago"
                    { old('tipo_pago.2')=="2" ? 'checked='.'"'.'checked'.'"' : '' } }
                    type="radio"
                    value="2"
                    name="tipo_pago[2]"
                    class="text-gray-600">

                    <span class="ml-2 text-gray-700">
                        Deposito
                    </span>

                </label>
            </div>

            <div class="px-6 pb-6 mt-2 hidden "  :class="{'hidden': tipo_pago != 2 }">
                <div class="flex items-center flex-wrap ">
                    <p class="font-semibold text-lg">Deposito al "BANCO UNION"</p>
                    <p class="text-sm">
                    Los datos para las transferencias bancarias son: <br>
                    -Nombre: Fundacion BCB <br>
                    -NIT: 000 000 000<br>
                    Cajas de ahorro en moneda Nacional:<br>
                    Banco Unión: 000 - 000 - 000 - 000 - 00<br>
                    <br>
                    Una vez hecha la transferencia, envíanos una foto del comprobante al chat en vivo,<br>
                    al número de Whatsapp +591 777 77 777 o al correo:
                    fundacion@fundacionculturalbcb.gob.bo con tu número de pedido para enviártelo.
                    </p>
                </div>
            </div>

        </div>

        {{-- formulario de envio  --}}
        <div class="shadow-lg bg-white text-lg  p-2 rounded-lg" x-data="{tipo_envio: @entangle('tipo_envio') }">
            <p class="my-3 font-bold text-lg text-black">4) Envío </p>
            <div>
                <label class="px-3 py-2 flex items-center">
                    <input x-model="tipo_envio"  type="radio" value="1" name="tipo_envio" class="text-gray-600">
                    <span class="ml-2 text-gray-700">
                        Envío a domicilio
                    </span>
                </label>

                <div class="px-6 pb-6 mt-2 hidden"  :class="{'hidden': tipo_envio != 1 }" >
                    <hr>
                    <div class="mb-2">
                        <label class="mb-1 text-base " for="direccion">
                         Dirección de Entrega (Detallada),
                        </label>

                        <textarea
                        class="
                            form-control
                            block
                            w-full
                            px-3
                            py-1.5
                            text-base
                            font-normal
                            text-gray-700
                            bg-white bg-clip-padding
                            border border-solid border-gray-300
                            rounded
                            transition
                            ease-in-out
                            m-0
                            focus:text-neutral-700 focus:bg-white focus:border-gray-600 focus:outline-none
                        "
                        id="direccion"
                        name="direccion"
                        wire:model.defer="direccion"
                        placeholder="Dirección donde le llegara el pedido"
                        @error('direccion')
                        border-red-500
                        @enderror
                        value="{{old('direccion')}}"
                        rows="3"
                        ></textarea>

                        @error('direccion')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                        @enderror

                    </div>

                    <div class="mb-2">
                        <label class="mb-1 text-base " for="ciudad_id">
                         Ciudad donde vive actualmente
                        </label>

                        <select
                        class=" w-full border border-gray-500  rounded  focus:outline-none focus:bg-white focus:border-gray-500"
                        wire:model="ciudad_id"
                        id="ciudad_id"
                        name="ciudad_id">

                            <option value="" disabled selected>- Selecciona tu Ciudad -</option>
                            @foreach ( $ciudades as $ciudad )
                                <option
                                {{ old('ciudad_id') == $ciudad->id ? 'selected' : '' }}
                                value="{{ $ciudad->id}}">
                                {{ $ciudad->nombre_ciudad }}
                                </option>
                            @endforeach


                        </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        @error('ciudad_id')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">Seleccione el departamento</p>
                        @enderror
                    </div>
                </div>
            </div>

            <label class=" px-3 py-2 flex items-center">
                <input x-model="tipo_envio" type="radio" value="2" name="tipo_envio" class="text-gray-600">
                <span class="ml-2 text-gray-700">
                    Recojo en tienda (calle falsa 123)
                </span>
            </label>
        </div>

        {{-- lista de resumen de pedidos --}}
        <div class="shadow-lg bg-white text-lg  p-4 rounded-lg row-span-2 ">
            <p class="my-3 font-bold text-lg text-black">5) Resumen de tu pedido</p>
            <div class="max-h-80 overflow-y-auto">
                <ul>
                    @forelse (Cart::content() as $item)

                    <li class="flex  border-gray-200">
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
            </div>
            <hr class="mt-4 mb-3">
            <div class="text-gray-700 p-2">
                <p class="flex justify-between items-center">
                    Subtotal
                    <span class="font-semibold">{{ Cart::subtotal() }} Bs</span>
                </p>

                <p class="flex justify-between items-center">
                    Envio
                    <span class="font-semibold">
                        @if ($tipo_envio != 1 || $costo_envio == 0)
                            Gratis
                        @else
                            {{  $costo_envio }} Bs
                        @endif

                    </span>
                </p>

                <hr class="mt-4 mb-3">

                <p class="flex justify-between items-center font-semibold">
                    Total
                    <span class="text-lg">
                        @if ($tipo_envio != 1)
                        {{ Cart::subtotal() }} Bs
                        @else
                        {{ Cart::subtotal() + $costo_envio}} Bs
                        @endif
                    </span>
                </p>

            </div>

            {{-- boton para confirmar pedido --}}
            <button
            wire:loading.attr="disabled"
            wire:target="create_order"
            wire:click="create_order"
            class="w-full px-16 bg-red-500 hover:bg-red-400 text-white font-bold py-2 mt-15 rounded-lg ">
            Realizar Pedido
        </button>
            {{-- fin de seccion boton de confirmar pedido --}}
        </div>



    </div>
</div>
