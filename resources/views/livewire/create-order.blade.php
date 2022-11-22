<div class="container mx-auto">
    <div class="grid lg:grid-flow-col h-auto lg:grid-cols-3 md:grid-cols-1 gap-4 p-5 bg-gray-300 ">
        {{-- formulario de datos personales --}}
        <div class="shadow-lg text-lg text-left bg-white py-5 rounded-lg row-span-2">
            <div class="px-5">
                <p class="my-2 font-bold text-lg text-black">1) Llena tus datos </p>
                <hr>
                <div class="mb-2">
                    <label class="text-base " for="nombre_contacto">
                        Nombre Completo
                    </label>

                    <input type="text" wire:model.defer="nombre_contacto" class="rounded-lg block shadow-sm w-full text-sm p-2.5 border @error('nombre_contacto') border-red-500 @enderror" placeholder="Ingrese el nombre completo" id="nombre_contacto" name="nombre_contacto" value="{{old('nombre_contacto')}}" />

                    @error('nombre_contacto')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-2">
                    <label class="text-base " for="correo_contacto">
                        Confirmación de Correo electronico.
                        <span class="text-gray-500 text-sm font-semibold italic"> (Para el cambio de correo se realiza en la sección Ver Perfil -> Datos personales)</span><br>
                        <span class="text-red-500 text-sm font-bold"> El correo electrónico será utilizado para recibir la facturación.*</span><br>
                    </label>

                    <input readonly type="email" wire:model.defer="correo_contacto"  class="block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-gray-100 bg-clip-padding border-solid rounded border @error('correo_contacto') border-red-500 @enderror" placeholder="Ingrese el su correo actual" id="correo_contacto" name="correo_contacto" value="{{old('correo_contacto')}}" />

                    @error('correo_contacto')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-2">
                    <label class="text-base " for="telefono_contacto">
                        Telefono/Celular
                    </label>

                    <input type="text" wire:model.defer="telefono_contacto" class="rounded-lg shadow-sm w-full text-sm p-2.5  border @error('telefono_contacto') border-red-500 @enderror" placeholder="Ingrese el su Telefono/Celular vigente" id="telefono_contacto" name="telefono_contacto" value="{{old('telefono_contacto')}}" />

                    @error('telefono_contacto')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>

                {{-- dato para la factura --}}

                <p class="mb-5 mt-10 font-bold text-lg text-black">2) Datos para la Factura </p>
                <hr>
                <div class="mb-2 mt-2">
                    <label class="text-base " for="nombre_factura">
                        Razon Social <span class="text-red-500 text-sm font-bold">(introduzca nombre para la factura)*</span>
                    </label>

                    <input type="text" wire:model.defer="nombre_factura" class="rounded-lg block shadow-sm w-full text-sm p-2.5 border @error('nombre_factura') border-red-500 @enderror" placeholder="Ingresa el Nombre/Razon Social" id="nombre_factura" name="nombre_factura" value="{{old('nombre_factura')}}" />

                    @error('nombre_factura')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-2">
                    <label class="text-base " for="nit_factura">
                        NIT
                    </label>

                    <input type="text" wire:model.defer="nit_factura" class="rounded-lg block shadow-sm w-full text-sm p-2.5 border @error('nit_factura') border-red-500 @enderror " placeholder="Ingrese NIT" id="nit_factura" name="nit_factura" value="{{old('nit_factura')}}" />

                    @error('nit_factura')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>
            </div>
        </div>
        {{-- fin formulario de datos personales --}}

        {{-- formulario de metodo de pago --}}
        <div class="shadow-lg bg-white text-lg  p-2 rounded-lg" x-data="{tipo_pago: @entangle('tipo_pago')}">
            <p class="my-3 font-bold text-lg text-black">3) Elige Método de Pago </p>
            <div>
                <label class="px-3 py-2 flex items-center">
                    <input x-model="tipo_pago" { old('tipo_pago.1')=="1" ? 'checked=' .'"'.'checked'.'"' : '' } type="radio" value="1" name="tipo_pago[1]" class="text-gray-600">
                    @error('tipo_pago')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror

                    <span class="ml-2 text-gray-700">
                        QR-SIMPLE
                    </span>
                </label>
            </div>

            <div class="p-2 mt-2 hidden" :class="{'hidden': tipo_pago != 1 }">
                <div class="flex items-center ml-3">
                    <p class="font-semibold text-base">
                        <i class="fa-solid fa-chevron-right"></i>
                        Info. Codigo QR
                    </p>
                    <button class="ml-2 bg-transparent hover:bg-green-600 text-green-700 font-semibold hover:text-white py-2 px-4 border border-green-700 hover:border-transparent rounded" type="button" onclick="toggleModal('modal-id-qr')">
                        <i class="fa-solid fa-qrcode fa-xl"></i>
                        Pago QR
                    </button>
                </div>
            </div>

            <div>
                <label class="px-3 py-2 flex items-center">
                    <input x-model="tipo_pago" { old('tipo_pago.2')=="2" ? 'checked=' .'"'.'checked'.'"' : '' } type="radio" value="2" name="tipo_pago[2]" class="text-gray-600">

                    <span class="ml-2 text-gray-700">
                        Deposito Banco Union
                    </span>

                </label>
            </div>

            <div class="p-2 mt-2 hidden " :class="{'hidden': tipo_pago != 2 }">
                <div class="flex items-center ml-3">
                    <p class="font-semibold text-base">
                        <i class="fa-solid fa-chevron-right"></i>
                        Info. Deposito
                    </p>
                    <button class="ml-2 bg-transparent hover:bg-green-600 text-green-700 font-semibold hover:text-white py-2 px-4 border border-green-700 hover:border-transparent rounded" type="button" onclick="toggleModal('modal-id-deposito')">
                        <i class="fa-sharp fa-solid fa-money-bill-1-wave fa-xl"></i>
                        Efectuar Deposito
                    </button>
                </div>
            </div>
            <hr>
            <p class="text-red-500 text-center font-semibold italic text-sm"><i class="fa-solid fa-circle-info"></i>¡Una vez hecha la transferencia, suba el comprobante de pago!</p>
            {{-- subir imagen de comprobante de pago --}}
            <div class="mb-2">
                <label class="text-base " for="imagen_factura">
                    <div class="flex my-2">
                        <p class="font-bold text-lg text-black pl-2">Subir Comprobante de Pago</p>
                        <div x-data="{ tooltip: false }" class="relative z-30 inline-flex">
                            <div x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false" class="rounded-md cursor-pointer fa-xl ml-2">
                                <i class="fa-solid fa-circle-exclamation"></i>
                            </div>
                            <div class="relative" x-cloak x-show.transition.origin.top="tooltip">
                                <div class="absolute top-0 z-10 w-64 p-2 -mt-1 text-sm leading-tight  transform -translate-x-1/2 -translate-y-full bg-gray-200 rounded-lg shadow-lg">
                                    <p class="font-bold border-b border-black">Información de Ayuda</p>

                                    <p>
                                        - Puede subir imagenes en formato <span class="font-semibold">(.jpg, .png, .jpeg)</span> o un documento en formato <span class="font-semibold">(.pdf)</span><br>
                                        - Asegurese que el deposito sea en la cuenta de la fundacion y que el monto sea el correcto.
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </label>

                <input id="imagen_deposito" name="imagen_deposito" type="file" wire:model.defer="imagen_deposito" class="rounded-lg block shadow-sm w-full text-sm p-2 border @error('imagen_deposito') border-red-500 @enderror" value="{{old('imagen_deposito')}}" accept=".jpg, .jpeg, .png, .pdf" />

                @error('imagen_deposito')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                @enderror
            </div>
            {{-- fin de seccion de comprobante de pago --}}

        </div>
        {{-- fin formulario de metodo de pago --}}

        {{-- formulario de envio  --}}
        <div class="shadow-lg bg-white text-lg  p-2 rounded-lg">
            <p class="my-3 font-bold text-lg text-black">4) Envío a domicilio</p>
            <div>
                <div class="px-6 pb-6 mt-2 ">
                    <hr>
                    <div class="mb-2">
                        <label class="text-base " for="direccion">
                            Dirección de Entrega (Detallada),
                        </label>

                        <textarea class="
                            form-control
                            block
                            w-full
                            px-3
                            py-1.5
                            text-base
                            font-normal
                            text-gray-700
                            bg-white bg-clip-padding
                            border border-solid
                            rounded
                            transition
                            ease-in-out
                            m-0
                            focus:text-neutral-700 focus:bg-white focus:border-gray-600 focus:outline-none
                            @error('direccion') border-red-500 @enderror
                        " id="direccion" name="direccion" wire:model.defer="direccion" placeholder="Zona/Calle o Avenida/Nro de Casa/Información Adicional" value="{{old('direccion')}}" rows="3"></textarea>

                        @error('direccion')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                        @enderror

                    </div>

                    <div class="mb-2">
                        <label class="text-base " for="ciudad_id">
                            Ciudad donde vive actualmente
                        </label>

                        <select class=" w-full border border-gray-500  rounded  focus:outline-none focus:bg-white focus:border-gray-500" wire:model="ciudad_id" id="ciudad_id" name="ciudad_id">

                            <option value="" disabled selected>- Selecciona tu Ciudad -</option>
                            @foreach ( $ciudades as $ciudad )
                            <option {{ old('ciudad_id') == $ciudad->id ? 'selected' : '' }} value="{{ $ciudad->id}}">
                                {{ $ciudad->nombre_ciudad }}
                            </option>
                            @endforeach

                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
                        </div>
                        @error('ciudad_id')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">Seleccione el departamento</p>
                        @enderror
                    </div>
                </div>
            </div>

        </div>
        {{-- fin formulario de envio --}}

        {{-- lista de resumen de pedidos --}}
        <div class="shadow-lg bg-white text-lg  p-4 rounded-lg row-span-2 ">
            <p class="my-3 font-bold text-lg text-black">5) Resumen de tu Orden de Compra</p>
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
                        {{ $costo_envio }} Bs
                    </span>
                </p>

                <hr class="mt-4 mb-3">

                <p class="flex justify-between items-center font-semibold">
                    Total
                    <span class="text-lg">
                        {{ str_replace( ',', '', Cart::subtotal() ) + $costo_envio}} Bs

                    </span>
                </p>

            </div>

            {{-- boton para confirmar pedido --}}
            <button wire:loading.attr="disabled" wire:target="create_order" wire:click="create_order" class="w-full px-16 bg-red-500 hover:bg-red-400 text-white font-bold py-2 mt-15 rounded-lg ">
                Realizar Compra
            </button>
            {{-- fin de seccion boton de confirmar pedido --}}
        </div>
        {{-- fin lista de resumen de pedidos --}}
    </div>

    {{-- Codigo Modal para el pago con codigo QR--}}
    <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center " id="modal-id-qr">
        <div class="relative mx-auto ">
            <!--content modal-->
            <div class="border-0 rounded-lg shadow-lg relative flex flex-col bg-white outline-none focus:outline-none">

                <!--body modal-->
                <div class="md:flex ">
                    <div class="w-96 px-2 text-justify">
                        <img class="align-middle md:max-w-md md:w-full w-32 " alt="codigo QR aplicacion wayruru" src="{{ asset('img/bancounionlogo.png')}}">
                        <p>
                            Ahora puede escanear el código QR para realizar el pago desde la aplicación móvil de su Entidad Financiera.
                        </p>
                        <br>
                        Se procederá a realizar el siguiente pago.
                        <p class="text-3xl my-4">
                            Total a Pagar: <span class="font-semibold">

                                {{ str_replace( ',', '', Cart::subtotal() ) + $costo_envio}}



                            </span>
                        </p>
                        <a class=" bg-sky-500 hover:bg-sky-700 text-center text-white font-bold py-2 px-4 rounded-lg" href="{{ route('qr.download')}}" target="_blank" rel="noopener noreferrer">
                            DESCARGAR QR
                        </a>
                        <p class="font-semibold py-2 text-center text-red-500 italic">¡Una vez hecha la transferencia, Guarda el comprobante de pago y súbalo en el formulario!</p>
                    </div>
                    <div class="md:mt-0 mt-5 object-center">
                        <img class="md:object-cover  md:max-w-md h-56 w-56  md:h-full md:w-full align-middle " alt="codigo QR aplicacion wayruru" src="{{ asset('img/qrprueba.jpeg')}}">
                    </div>
                </div>


                <!--footer del modal-->
                <div class="flex items-center justify-end p-2 border-t border-solid border-slate-200 rounded-b">

                    <button class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="toggleModal('modal-id-qr')">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-qr-backdrop"></div>
    {{-- fin modal de pago QR--}}

    {{-- Codigo Modal para el pago con DEPOSITO--}}
    <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center " id="modal-id-deposito">
        <div class="relative mx-auto ">
            <!--content modal-->
            <div class="border-0 rounded-lg shadow-lg relative flex flex-col bg-white outline-none focus:outline-none">

                <!--body modal-->
                <div class="md:flex">
                    <div class="w-96 px-2">
                        <img class="align-middle md:max-w-md md:w-full w-32 " alt="codigo QR aplicacion wayruru" src="{{ asset('img/bancounionlogo.png')}}">
                        <div class="flex items-center flex-wrap text-lg">
                            <p class="font-bold text-center text-xl">Deposito "BANCO UNION"</p> <br>
                            <p> Los datos para las transferencias bancarias son: </p>
                            <p><span class="font-bold"> Nombre:</span>Fundacion Cultural BCB</p>
                            <p><span class="font-bold">NIT:</span> 000 000 000</p>
                            <p><span class="font-bold">Cajas de ahorro en moneda Nacional "Banco Unión":</span> 000 - 000 - 000 - 000 - 00</p>
                            <p><span class="font-bold">Correo de Contacto:</span>
                                fundacion@fundacionculturalbcb.gob.bo </p>
                            <p><span class="font-bold">Telefono:</span>(+591) 2 424148 - 2 418419</p>
                        </div>
                        <p class="text-3xl my-4 border-t-2 border-black">
                            Total a Pagar: <span class="font-semibold">
                                {{ str_replace( ',', '', Cart::subtotal() ) + $costo_envio}}
                            </span>
                            <p class="border-y-2 text-red-500 text-center border-black font-semibold italic">¡Una vez hecha el deposito, Guarda el comprobante de pago y súbalo en el formulario!</p>
                        </p>

                    </div>
                </div>


                <!--footer del modal-->
                <div class="flex items-center justify-end p-2 border-t border-solid border-slate-200 rounded-b">

                    <button class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="toggleModal('modal-id-deposito')">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-deposito-backdrop"></div>
    {{-- fin modal de pago DEPOSITO--}}
</div>

<script type="text/javascript">
    function toggleModal(modalID) {
        document.getElementById(modalID).classList.toggle("hidden");
        document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
        document.getElementById(modalID).classList.toggle("flex");
        document.getElementById(modalID + "-backdrop").classList.toggle("flex");
    }

</script>
