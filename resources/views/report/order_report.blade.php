<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
     <!-- Styles - Scripts -->
     <link rel="stylesheet" href="{{ public_path('css/app.css') }}" type="text">
</head>
<body>
   <!-- Table -->
   <div class="w-full  mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
    <header class="px-5 py-4 border-b border-gray-100">
        <div class="font-semibold text-gray-800">Ordenes</div>
    </header>

    <div class="overflow-x-auto p-3">
        <table class="table-auto w-full">
            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                <tr>
                    <th></th>
                    <th class="p-2">
                        <div class="font-semibold text-left">Nro. Orden</div>
                    </th>
                    <th class="p-2">
                        <div class="font-semibold text-left">Total</div>
                    </th>
                    <th class="p-2">
                        <div class="font-semibold text-left">Nro Productos</div>
                    </th>
                    <th class="p-2">
                        <div class="font-semibold text-left">Correo</div>
                    </th>

                </tr>
            </thead>

            <tbody class="text-sm divide-y divide-gray-100">

                <!-- tabla de datos -->
                @foreach ($orders as $order)


                    <tr class="hover:bg-gray-100">
                        <td class="p-2">
                            <div class="font-semibold text-center">{{ $order->id }}</div>
                        </td>
                        <td class="p-2">
                            <div class="font-medium text-gray-800 w-64">
                                {{ $order->total }}
                            </div>
                        </td>
                        <td class="p-2">
                            <div class="text-left">
                               {{ $order->costo_envio}}
                            </div>
                        </td>
                        <td class="p-2">
                            <div class="text-left">
                               {{ $order->nombre_contacto}}
                            </div>
                        </td>
                    </tr>

                    <div class="bg-white rounded-lg shadow-lg p-6 mb-6 ">
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
                                    @foreach (json_decode($order->content) as $item)
                                    <tr>
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
                                        </td>>
                                    </tr>
                                    @endforeach
                                </tbody>

                        </table>
                        </div>
                    </div>
                @endforeach

            </tbody>
        </table>
    </div>

</body>
</html>
