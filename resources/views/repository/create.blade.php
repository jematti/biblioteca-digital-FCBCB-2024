@extends('ui.nav')

@section('contenido-admin')


    <h2 class="bg-white text-lg rounded-lg p-4 text-center font-bold border-2 border-sky-800">Repositorio</h2>

    {{-- menu de navegacion para crear y editar repositorios --}}
    <div class="md:grid grid-cols-2 gap-1  sm:flex-grow">
        <div class="my-2 p-2">
            <button class="w-full p-2 uppercase bg-sky-600 text-white font-bold hover:bg-sky-700 border border-gray-900  rounded-lg " onclick="location.href = '{{ route('repository.create') }}'">
                <i class="fa-solid fa-plus"></i><span class="px-2">Agregar Repositorio</span>
            </button>
        </div>
        <div class="my-2 p-2">
            <button class="w-full p-2 uppercase  bg-sky-600 text-white font-bold hover:bg-sky-700 border border-gray-900  rounded-lg " onclick="location.href = '{{ route('repository.index') }}'">
                <i class="fa-solid fa-angle-down"></i><span class="px-2">Listar Repositorio</span>
            </button>
        </div>
    </div>

      {{-- formulario para agregar repositorio --}}
      <form action="{{ route('repository.store') }}" method="POST" novalidate>

        @csrf
        <div class="mb-5">
            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="w-full px-3">
                    <label for="nombre_repositorio" class="mb-2 block uppercase text-gray-500 font-bold">
                        Nombre del Repositorio
                    </label>
                    <input
                        id="nombre_repositorio"
                        type="text"
                        name="nombre_repositorio"
                        placeholder="Nombre del Repositorio"
                        class="border p-3 w-full rounded-lg"
                        @error('nombre_repositorio')
                            border-red-500
                        @enderror
                        value="{{old('nombre_repositorio')}}"
                    />
                    @error('nombre_repositorio')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="w-full px-3">
                    <label for="correo" class="mb-2 block uppercase text-gray-500 font-bold">
                        Correo Electronico
                    </label>
                    <input
                        id="correo"
                        type="text"
                        name="correo"
                        placeholder="correo electronico"
                        class="border p-3 w-full rounded-lg"
                        @error('correo')
                            border-red-500
                        @enderror
                        value="{{old('correo')}}"
                    />
                    @error('correo')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="w-full px-3">
                    <label for="nombre_encargado" class="mb-2 block uppercase text-gray-500 font-bold">
                        Nombre del Encargado del Repositorio
                    </label>
                    <input
                        id="nombre_encargado"
                        type="text"
                        name="nombre_encargado"
                        placeholder="Nombre del Encargado del Repositorio"
                        class="border p-3 w-full rounded-lg"
                        @error('nombre_encargado')
                            border-red-500
                        @enderror
                        value="{{old('nombre_encargado')}}"
                    />
                    @error('nombre_encargado')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>
            </div>


            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="w-full px-3">
                    <label for="direccion" class="mb-2 block uppercase text-gray-500 font-bold">
                        Dirección
                    </label>
                    <input
                        id="direccion"
                        type="text"
                        name="direccion"
                        placeholder="Dirección Actual"
                        class="border p-3 w-full rounded-lg"
                        @error('direccion')
                            border-red-500
                        @enderror
                        value="{{old('direccion')}}"
                    />
                    @error('direccion')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="w-full px-3">
                    <label for="ubicacion" class="mb-2 block uppercase text-gray-500 font-bold">
                        Ubicacion Google Maps Repositorio (Opcional)
                    </label>
                    <input
                        id="ubicacion"
                        type="text"
                        name="ubicacion"
                        placeholder="Dirección Actual"
                        class="border p-3 w-full rounded-lg"
                        value="{{old('ubicacion')}}"
                    />
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="w-full md:w-1/2 px-3 mb-3 md:mb-0">
                    <label for="sigla" class="mb-2 block uppercase text-gray-500 font-bold">
                        Sigla de Repositorio
                    </label>
                    <input
                        id="sigla"
                        type="text"
                        name="sigla"
                        placeholder="Escribir la Sigla del Repositorio"
                        class="border p-3 w-full rounded-lg"
                        @error('sigla')
                            border-red-500
                        @enderror
                        value="{{old('sigla')}}"
                    />
                    @error('sigla')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>
                <div class="w-full md:w-1/2 px-3 mb-3 md:mb-0">
                    <label class="mb-2 block uppercase text-gray-500 font-bold" >
                        Ciudad:
                    </label>
                    <select
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="ciudad"
                        name="ciudad"

                    >
                            {{ $ciudad="" }}
                            <option value="">- Seleccione la Sucursal- </option>
                            <option value="La Paz" {{ old('ciudad', $ciudad)=='La Paz' ? 'selected':'' }}>La Paz</option>
                            <option value="Potosi" {{ old('ciudad', $ciudad)=='Potosi' ? 'selected':'' }}>Potosi</option>
                            <option value="Sucre" {{ old('ciudad', $ciudad)=='Sucre' ? 'selected':'' }}>Sucre</option>
                            <option value="Santa Cruz" {{ old('ciudad', $ciudad)=='Santa Cruz' ? 'selected':'' }}>Santa Cruz</option>
                    </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    @error('ciudad')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="w-full px-3">

                    <label for="horario_atencion" class="mb-2 block uppercase text-gray-500 font-bold">
                        Horario de Atención
                    </label>
                    <input
                        id="horario_atencion"
                        type="text"
                        name="horario_atencion"
                        placeholder="Ej: Lunes a Viernes de 8:00 a 18:00"
                        class="border p-3 w-full rounded-lg"
                        @error('horario_atencion')
                            border-red-500
                        @enderror
                        value="{{old('horario_atencion')}}"
                    />
                    @error('horario_atencion')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror

                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="w-full px-3">
                    <label for="telefono" class="mb-2 block uppercase text-gray-500 font-bold">
                        Telefono
                    </label>
                    <input
                        id="telefono"
                        type="text"
                        name="telefono"
                        placeholder="Telefono o celular de referencia"
                        class="border p-3 w-full rounded-lg"
                        @error('telefono')
                            border-red-500
                        @enderror
                        value="{{old('telefono')}}"
                    />
                    @error('telefono')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="w-full px-3">
                    <label for="pagina_web" class="mb-2 block uppercase text-gray-500 font-bold">
                        Pagina Web del Repositorio
                    </label>
                    <input
                        id="pagina_web"
                        type="text"
                        name="pagina_web"
                        placeholder="Direccion de la Pagina web Oficial"
                        class="border p-3 w-full rounded-lg"
                        @error('pagina_web')
                            border-red-500
                        @enderror
                        value="{{old('pagina_web')}}"
                    />
                    @error('pagina_web')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror

                </div>
            </div>

            <input
                type="submit"
                value="Añadir Repositorio"
                class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg p-3 mt-5"
            />
    </form>
@endsection
