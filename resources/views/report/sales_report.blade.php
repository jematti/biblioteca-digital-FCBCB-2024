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
                        Reporte de Ventas
                        <br>
                        <span class="text-sm">Fecha Inicio:{{ $fecha_inicio }}</span>
                        <span class="text-sm">Fecha Fin:{{ $fecha_fin }}</span>
                    </th>
                    <th style="border: hidden" class="text-xs justify-center ml-20">Fecha: <br>{{$now->format('Y-m-d')}} <br><span>{{$now->format('H:i:s')}}</span></th>
                </tr>
            </thead>
        </table>

    </div>
    <!-- Tabla de productos -->
    <div>
        <table class="table-auto text-xs ">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Ubicación</th>
                    <th>Precio</th>
                    <th>Ejemplares solicitados</th>
                    <th>Total</th>
                    <th>Nro. Orden</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->product_id }}</td>

                        <td>{{ $item->qty}}</td>
                        <td>{{ $item->order_id }}</td>

                    </tr>

                @endforeach
            </tbody>
        </table>
    </div>

    <br>
    {{-- fin de tabla de muestra de productos --}}




</body>
</html>
