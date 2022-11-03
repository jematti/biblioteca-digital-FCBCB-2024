<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Styles - Scripts -->

    <link rel="stylesheet" href="{{ public_path('css/app.css') }}" type="text">
    <style>
        table {
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 5px;
        }

    </style>
</head>
<body>

    <div>
        <table>
            <thead style="border: hidden">
                <tr>
                    <th style="border: hidden,text-align: left"><img src="{{ public_path('img/logofcbcbpq.jpg') }}"></th>
                    <th style="border: hidden" class="px-5 text-xs">
                        ORDENES DE COMPRA
                        @switch($order_type)
                        @case(1)
                        "PENDIENTES"
                        @break
                        @case(2)
                        "RECIBIDOS"
                        @break
                        @case(3)
                        "ENVIADOS"
                        @break
                        @case(4)
                        "ENTREGADOS"
                        @break
                        @case(5)
                        "ANULADOS"
                        @break
                        @case(6)
                        "PENDIENTES"-"ANULADOS" -"RECIBIDOS"-"ENVIADOS"-"ENTREGADOS"-"ANULADOS"
                        @break
                        @default

                        @endswitch
                        <br>
                        <span class="text-sm">Fecha Inicio:{{ $fecha_inicio }}</span>
                        <span class="text-sm">Fecha Fin:{{ $fecha_fin }}</span>
                    </th>
                    <th style="border: hidden" class="text-xs justify-center ml-20">Fecha: <br>{{$now->format('Y-m-d')}} <br><span>{{$now->format('H:i:s')}}</span></th>
                </tr>
            </thead>
        </table>

    </div>
    @foreach ($orders as $order)
    <!-- Tabla de productos -->
    @if ($order->estado == $order_type)
    <div>
        <table style="table-auto">>
            <tbody class="text-xs">
                <tr>
                    <th style="background-color: #090D2A; color: white;" colspan="3">
                        Nro de Orden: {{ $order->id }}
                    </th>
                </tr>
                <tr>
                    <th>Nro. Factura: {{ $order->nro_factura }}</th>
                    <th>Nombre/Razon Social: {{ $order->nombre_factura }}</th>
                    <th>NIT: {{ $order->nit_factura }}</th>
                </tr>
                <tr>
                    <th>Total: {{ $order->total }}</th>
                    <th>Subtotal: {{ $order->total - $order->costo_envio }}</th>
                    <th>Envío: {{ $order->costo_envio }}</th>
                </tr>
                <tr>
                    <th>Enviado a: {{ $order->nombre_contacto }}</th>
                    <th>Correo: {{ $order->user->email }}</th>
                    <th>Tel/cel: {{ $order->telefono_contacto }}</th>
                </tr>
            </tbody>
        </table>
        <h2 class="text-center font-bold"> Listado de Productos Adquiridos</h2>
        <table class="table-auto text-xs ">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Ubicación</th>
                    <th>Precio</th>
                    <th>Ejemplares solicitados</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach (json_decode($order->content) as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->options->repositorio }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->qty}}</td>
                    <td> {{ $item->price * $item->qty }} Bs</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    @if ($order_type == 6)
    <div>
        <table style="table-auto">>
            <tbody class="text-xs">
                <tr>
                    <th style="background-color: #090D2A; color: white;" colspan="2">
                        Nro de Orden: {{ $order->id }}
                    </th>
                    <th style="background-color: #090D2A; color: white;" >
                        Estado de Orden:
                        @switch($order->estado)
                        @case(1)
                        "PENDIENTE"
                        @break
                        @case(2)
                        "RECIBIDO"
                        @break
                        @case(3)
                        "ENVIADO"
                        @break
                        @case(4)
                        "ENTREGADO"
                        @break
                        @case(5)
                        "ANULADO"
                        @break
                        @default

                        @endswitch
                    </th>
                </tr>
                <tr>
                    <th>Nro. Factura: {{ $order->nro_factura }}</th>
                    <th>Nombre/Razon Social: {{ $order->nombre_factura }}</th>
                    <th>NIT: {{ $order->nit_factura }}</th>
                </tr>
                <tr>
                    <th>Total: {{ $order->total }}</th>
                    <th>Subtotal: {{ $order->total - $order->costo_envio }}</th>
                    <th>Envío: {{ $order->costo_envio }}</th>
                </tr>
                <tr>
                    <th>Enviado a: {{ $order->nombre_contacto }}</th>
                    <th>Correo: {{ $order->user->email }}</th>
                    <th>Tel/cel: {{ $order->telefono_contacto }}</th>
                </tr>
            </tbody>
        </table>
        <h2 class="text-center font-bold"> Listado de Productos Adquiridos</h2>
        <table class="table-auto text-xs ">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Ubicación</th>
                    <th>Precio</th>
                    <th>Ejemplares solicitados</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach (json_decode($order->content) as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->options->repositorio }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->qty}}</td>
                    <td> {{ $item->price * $item->qty }} Bs</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    @endif
    <br>
    @endforeach
    {{-- fin de tabla de muestra de productos --}}




</body>
</html>
