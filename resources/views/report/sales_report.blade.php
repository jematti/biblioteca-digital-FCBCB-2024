@foreach ($products as $product)
        <p>{{ $product->id }},{{ $product->titulo }} </p>
        <p>{{ $product->repository->nombre_repositorio }}</p>
        <p>{{ $product->author->nombre_autor}}</p>
        <p>{{ $product->category->nombre_categoria }}</p>

@endforeach
