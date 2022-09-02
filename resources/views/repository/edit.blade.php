@extends('ui.nav')

@section('contenido-admin')


<h2 class="bg-custom-100 text-white uppercase text-lg rounded-lg p-4 text-center font-bold ">Editar Repositorio</h2>

{{-- formulario para agregar repositorio --}}
<form action="{{ route('repository.update',['repository'=>$repository->id]) }}" method="POST" novalidate class="actualizar">

    @csrf
    @method('PUT')
    <div class="grid grid-cols-2 gap-5 border-t-2 ">
        <div class="mt-5">


            {{-- nombre de repositorio --}}
            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="w-full px-3">
                    <label for="nombre_repositorio" class="mb-2 block uppercase text-gray-500 font-bold">
                        Nombre del Repositorio
                    </label>
                    <input id="nombre_repositorio" type="text" name="nombre_repositorio" placeholder="Nombre del Repositorio" class="border p-3 w-full rounded-lg" @error('nombre_repositorio') border-red-500 @enderror value="{{$repository->nombre_repositorio}}" />
                    @error('nombre_repositorio')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>
            </div>
            {{-- correo electronico de repositorio --}}
            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="w-full px-3">
                    <label for="correo" class="mb-2 block uppercase text-gray-500 font-bold">
                        Correo Electronico
                    </label>
                    <input id="correo" type="text" name="correo" placeholder="correo electronico" class="border p-3 w-full rounded-lg" @error('correo') border-red-500 @enderror value="{{$repository->correo}}" />
                    @error('correo')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>
            </div>
            {{-- nombre del encargado de repostiorio --}}
            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="w-full px-3">
                    <label for="nombre_encargado" class="mb-2 block uppercase text-gray-500 font-bold">
                        Nombre del Encargado del Repositorio
                    </label>
                    <input id="nombre_encargado" type="text" name="nombre_encargado" placeholder="Nombre del Encargado del Repositorio" class="border p-3 w-full rounded-lg" @error('nombre_encargado') border-red-500 @enderror value="{{$repository->nombre_encargado}}" />
                    @error('nombre_encargado')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>
            </div>
            {{-- direccion de repositorio --}}
            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="w-full px-3">
                    <label for="direccion" class="mb-2 block uppercase text-gray-500 font-bold">
                        Dirección
                    </label>
                    <input id="direccion" type="text" name="direccion" placeholder="Dirección Actual" class="border p-3 w-full rounded-lg" @error('direccion') border-red-500 @enderror value="{{$repository->direccion}}" />
                    @error('direccion')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>
            </div>
            {{-- ubicacion de repositorio por google maps --}}
            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="w-full px-3">
                    <label for="ubicacion" class="mb-2 block uppercase text-gray-500 font-bold">
                        Ubicacion Google Maps Repositorio (Opcional)
                    </label>
                    <input id="ubicacion" type="text" name="ubicacion" placeholder="Insertar desde el Mapa de Google Maps" class="border p-3 w-full rounded-lg" value="{{$repository->ubicacion}}" />
                </div>
            </div>
        </div>

        <div class="mt-5">
            {{-- sigla y ciudad de repositorio --}}
            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="w-full md:w-1/2 px-3 mb-3 md:mb-0">
                    <label for="sigla" class="mb-2 block uppercase text-gray-500 font-bold">
                        Sigla de Repositorio
                    </label>
                    <input id="sigla" type="text" name="sigla" placeholder="Escribir la Sigla del Repositorio" class="border p-3 w-full rounded-lg" @error('sigla') border-red-500 @enderror value="{{$repository->sigla}}" />

                </div>
                <div class="w-full md:w-1/2 px-3 mb-3 md:mb-0">
                    <label class="mb-2 block uppercase text-gray-500 font-bold">
                        Ciudad:
                    </label>
                    <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="ciudad" name="ciudad">
                        <option disabled selected>- Seleccione la Sucursal- </option>
                        <option value="La Paz" {{ ($repository->ciudad)=='La Paz' ? 'selected':'' }}>La Paz</option>
                        <option value="Potosi" {{ ($repository->ciudad)=='Potosi' ? 'selected':'' }}>Potosi</option>
                        <option value="Sucre" {{  ($repository->ciudad)=='Sucre' ? 'selected':'' }}>Sucre</option>
                        <option value="Santa Cruz" {{  ($repository->ciudad)=='Santa Cruz' ? 'selected':'' }}>Santa Cruz</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
                    </div>
                    @error('ciudad')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>
            </div>
            {{-- horario de atencion --}}
            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="w-full px-3">

                    <label for="horario_atencion" class="mb-2 block uppercase text-gray-500 font-bold">
                        Horario de Atención
                    </label>
                    <input id="horario_atencion" type="text" name="horario_atencion" placeholder="Ej: Lunes a Viernes de 8:00 a 18:00" class="border p-3 w-full rounded-lg" @error('horario_atencion') border-red-500 @enderror value="{{$repository->horario_atencion}}" />
                    @error('horario_atencion')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror

                </div>
            </div>
            {{-- telefono de contacto --}}
            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="w-full px-3">
                    <label for="telefono" class="mb-2 block uppercase text-gray-500 font-bold">
                        Telefono
                    </label>
                    <input id="telefono" type="text" name="telefono" placeholder="Telefono o celular de referencia" class="border p-3 w-full rounded-lg" @error('telefono') border-red-500 @enderror value="{{$repository->telefono}}" />
                    @error('telefono')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>
            </div>
            {{-- pagina web del repositorio --}}
            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="w-full px-3">
                    <label for="pagina_web" class="mb-2 block uppercase text-gray-500 font-bold">
                        Pagina Web del Repositorio
                    </label>
                    <input id="pagina_web" type="text" name="pagina_web" placeholder="Direccion de la Pagina web Oficial" class="border p-3 w-full rounded-lg" @error('pagina_web') border-red-500 @enderror value="{{$repository->pagina_web}}" />
                    @error('pagina_web')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror

                </div>
            </div>
            {{-- botones de guardar - cancelar cambios --}}
            <div class="flex flex-row-reverse  my-5 text-right">
                <input type="submit" value="Guardar Cambios" class="w-1/2 text-white bg-sky-600 hover:bg-sky-700 uppercase font-bold focus:ring-4 font-lg rounded-lg text-sm px-5 py-2.5 text- mr-2 mb-2 " />
                <a class=" text-white bg-red-600 hover:bg-red-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 " href="{{ route('repository.index') }}">Cancelar</a>
            </div>
        </div>
</form>
@endsection
