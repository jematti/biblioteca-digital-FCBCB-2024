@extends('ui.nav')

@section('contenido-admin')

    <h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Lista de Categorias</h2>

    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
   {{-- menu de navegacion para crear y editar categorias --}}
   <div class="md:grid grid-cols-2 gap-1  sm:flex-grow">
        <div class="my-2 p-2 ">
            <button class="w-full p-2 uppercase bg-sky-600 text-white font-bold hover:bg-sky-700 border border-gray-900  rounded-lg" onclick="location.href = '{{ route('category.create') }}'">
                <i class="fa-solid fa-plus"></i><span class="px-2">Agregar Categoria</span>
            </button>
        </div>
        <div class="my-2 p-2 ">
            <button class="w-full p-2 uppercase bg-sky-600 text-white font-bold hover:bg-sky-700 border border-gray-900  rounded-lg" onclick="location.href = '{{ route('category.index') }}'">
                <i class="fa-solid fa-angle-down"></i><span class="px-2">Listar Categorias</span>
            </button>
        </div>
   </div>



    <!-- Table -->
        <div class="w-full mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
            <header class="px-5 py-4 border-b border-gray-100">
                <div class="font-semibold text-gray-800">Categorias</div>
            </header>

            <div class="overflow-x-auto p-3">
                <table class="table-auto w-full">
                    <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                        <tr>
                            <th></th>
                            <th class="p-2">
                                <div class="font-semibold text-left">Nombre</div>
                            </th>
                            <th class="p-2">
                                <div class="font-semibold text-left">Descripcion</div>
                            </th>
                            <th class="p-2">
                                <div class="font-semibold text-left">Editar </div>
                            </th>
                            {{-- sección de eliminar --}}
                            {{-- <th class="p-2">
                                <div class="font-semibold text-center">Eliminar</div>
                            </th> --}}
                        </tr>
                    </thead>

                    <tbody class="text-sm divide-y divide-gray-100">

                        <!-- tabla de datos -->
                        @foreach ($category as $categories)
                            <tr>
                                <td class="p-2">
                                    <div class="font-semibold text-center">{{ $categories->id }}</div>
                                </td>
                                <td class="p-2">
                                    <div class="font-medium text-gray-800">
                                        {{ $categories->nombre_categoria }}
                                    </div>
                                </td>
                                <td class="p-2">
                                    <div class="text-left">
                                       {{ $categories->descripcion }}
                                    </div>
                                </td>
                                {{-- seccion editar --}}
                                <td class="p-2">
                                        <div class="flex justify-center">

                                            {{-- editar --}}
                                            <a href="{{ route('category.edit',$categories->id) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>

                                        </div>
                                </td>

                              {{-- seccion eliminar --}}
                                {{-- <td class="p-2">
                                    <form action="{{ route('category.destroy',$categories->id) }}" method="POST" class="delete-category">
                                        <div class="flex justify-center">
                                            <button >
                                                @csrf
                                                @method('DELETE')
                                                <svg class="w-8 h-8 hover:text-blue-600 rounded-full hover:bg-gray-100 p-1"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                </td> --}}

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            {{-- paginacion --}}
            <div class="m-10">
                {{ $category->links() }}
            </div>
@endsection

@section('js')

{{-- mensaje de exito de eliminacion --}}
@if(session('eliminar') == 'ok')

    <script>
        Swal.fire({
        icon: 'success',
        title: 'Se elimino correctamente',
        showConfirmButton: false,
        timer: 1500
        })
    </script>
@endif

{{-- mensaje de exito de agregacion de Categoria --}}
@if(session('store') == 'ok')

    <script>
        Swal.fire({
        icon: 'success',
        title: 'Se creado la Categoria Correctamente',
        showConfirmButton: false,
        timer: 2000
        })
    </script>
@endif

{{-- mensaje de exito de actualizacion correcta --}}
@if(session('update') == 'ok')

    <script>
        Swal.fire({
        icon: 'success',
        title: 'Se ha actualizado los datos Correctamente',
        showConfirmButton: false,
        timer: 2000
        })
    </script>
@endif

{{-- solicitud de confirmacion de eliminacion --}}
<script type="text/javascript">


    $('.delete-category').submit(function(e){

      //previene el comportamiento por defecto del formulario
      e.preventDefault();

      Swal.fire({
      title: '¿Esta Seguro de Eliminar esta Categoria?',
      text: "¡Esta accion no es reversible!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, estoy Seguro',
      }).then((result) => {
          if (result.value) {
            this.submit();
          }
          })
    });
 </script>


@endsection
