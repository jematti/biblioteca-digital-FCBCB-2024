<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Styles - Scripts -->

    <link rel="stylesheet" href="{{ public_path('css/app.css') }}" type="text">
    <style>
        .grid-container {
  display: grid;
  gap: 50px;
}
.item1 {
  grid-row-start: 1;
  grid-row-end: 3;
}

    </style>
</head>
<body>
    <div class="grid-container">
        <div class="grid-item">1</div>
        <div class="grid-item">2</div>
        <div class="grid-item">3</div>
        <div class="grid-item">4</div>
        <div class="grid-item">5</div>
        <div class="grid-item">6</div>
        <div class="grid-item">7</div>
        <div class="grid-item">8</div>
        <div class="grid-item">9</div>
    </div>


    <div class="col-span-1"></div>
    @foreach ($orders as $order)
    <div class="grid grid-cols-3 gap-4">
        <div class="col-span-3"></div>

        <div class="col-span-1">FC-BCB</div>
        <div class="col-span-1">Reporte de Ordenes de Compra: Entregados</div>
        <div class="col-span-1">Fecha: </div>

        <div class="col-span-1">Nro de Orden: {{ $order->id }} </div>
        <div class="col-span-2">Estado: {{ $order->estado }}</div>

        <div class="col-span-1">Nro. Factura: {{ $order->nro_factura }}</div>
        <div class="col-span-1">Nombre/Razon Social: {{ $order->nombre_factura }}</div>
        <div class="col-span-1">NIT: {{ $order->nit_factura }}</div>

        <div class="col-span-1">Total: {{ $order->total }}</div>
        <div class="col-span-1">Subtotal {{ $order->total - $order->costo_envio }}</div>
        <div class="col-span-1">Envío: {{ $order->costo_envio }}</div>

        <div class="col-span-1">Enviado a: {{ $order->nombre_contacto }}</div>
        <div class="col-span-1">Correo: {{ $order->user->email }}</div>
        <div class="col-span-1">Tel/cel: {{ $order->telefono_contacto }}</div>

    </div>
    <!-- Table -->
    <div>
        <table class="table-auto border-separate border border-green-900">
            <thead>
                <tr>
                    <th class="border ">ID</th>
                    <th class="border">Título</th>
                    <th class="border ">Ubicación</th>
                    <th class="border ">Precio</th>
                    <th class="border ">Ejemplares solicitados</th>
                    <th class="border ">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach (json_decode($order->content) as $item)
                <tr>
                    <td class="border">{{ $item->id }}</td>
                    <td class="border">{{ $item->name }}</td>
                    <td class="border">{{ $item->options->ubicacion }}</td>
                    <td class="border">{{ $item->price }}</td>
                    <td class="border">{{ $item->qty}}</td>
                    <td class="border"> {{ $item->price * $item->qty }} Bs</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach
    </div>

</body>
</html>
