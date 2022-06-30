@extends('layouts.app')


@section('contenido')

{{-- Seccion de carrousel de ofertas --}}
    <div class="carousel relative container mx-auto" style="max-width:1600px;">
        <div class="carousel-inner relative overflow-hidden w-full">
            <!--Slide 1-->
            <input class="carousel-open" type="radio" id="carousel-1" name="carousel" aria-hidden="true" hidden="" checked="checked">
            <div class="carousel-item absolute opacity-0" style="height:50vh;">
                <div class="block h-full w-full mx-auto pt-6 md:pt-0 md:items-center bg-cover bg-right" style="background-image: url('{{ asset('img/bn1.jpeg')}}');">

                    <div class="container mx-auto">
                        <div class="flex flex-col w-full lg:w-1/2 md:ml-16 items-center md:items-start px-6 tracking-wide">
                            <p class="text-black text-2xl my-4">Libros en Tendencia</p>
                            <a class="text-xl inline-block no-underline border-b border-gray-600 leading-relaxed hover:text-black hover:border-black" href="#">view product</a>
                        </div>
                    </div>

                </div>
            </div>
            <label for="carousel-3" class="prev control-1 w-10 h-10 ml-2 md:ml-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900 leading-tight text-center z-10 inset-y-0 left-0 my-auto">‹</label>
            <label for="carousel-2" class="next control-1 w-10 h-10 mr-2 md:mr-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900 leading-tight text-center z-10 inset-y-0 right-0 my-auto">›</label>

            <!--Slide 2-->
            <input class="carousel-open" type="radio" id="carousel-2" name="carousel" aria-hidden="true" hidden="">
            <div class="carousel-item absolute opacity-0 bg-cover bg-right" style="height:50vh;">
                <div class="block h-full w-full mx-auto  pt-6 md:pt-0 md:items-center bg-cover bg-right" style="background-image: url('{{ asset('img/bn2.jpeg')}}');">

                    <div class="container mx-auto">
                        <div class="flex flex-col w-full lg:w-1/2 md:ml-16 items-center md:items-start px-6 tracking-wide">
                            <p class="text-black text-2xl my-4">Libros por temporada</p>
                            <a class="text-xl inline-block no-underline border-b border-gray-600 leading-relaxed hover:text-black hover:border-black" href="#">view product</a>
                        </div>
                    </div>

                </div>
            </div>
            <label for="carousel-1" class="prev control-2 w-10 h-10 ml-2 md:ml-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900  leading-tight text-center z-10 inset-y-0 left-0 my-auto">‹</label>
            <label for="carousel-3" class="next control-2 w-10 h-10 mr-2 md:mr-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900  leading-tight text-center z-10 inset-y-0 right-0 my-auto">›</label>

            <!--Slide 3-->
            <input class="carousel-open" type="radio" id="carousel-3" name="carousel" aria-hidden="true" hidden="">
            <div class="carousel-item absolute opacity-0" style="height:50vh;">
                <div class="block h-full w-full mx-auto pt-6 md:pt-0 md:items-center bg-cover bg-bottom" style="background-image: url('{{ asset('img/b3.jpg')}}');">

                    <div class="container mx-auto">
                        <div class="flex flex-col w-full lg:w-1/2 md:ml-16 items-center md:items-start px-6 tracking-wide">
                            <p class="text-black text-2xl my-4">Eventos Semanal</p>
                            <a class="text-xl inline-block no-underline border-b border-gray-600 leading-relaxed hover:text-black hover:border-black" href="#">view product</a>
                        </div>
                    </div>

                </div>
            </div>
            <label for="carousel-2" class="prev control-3 w-10 h-10 ml-2 md:ml-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900  leading-tight text-center z-10 inset-y-0 left-0 my-auto">‹</label>
            <label for="carousel-1" class="next control-3 w-10 h-10 mr-2 md:mr-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900  leading-tight text-center z-10 inset-y-0 right-0 my-auto">›</label>

            <!-- Add additional indicators for each slide-->
            <ol class="carousel-indicators">
                <li class="inline-block mr-3">
                    <label for="carousel-1" class="carousel-bullet cursor-pointer block text-4xl text-gray-400 hover:text-gray-900">•</label>
                </li>
                <li class="inline-block mr-3">
                    <label for="carousel-2" class="carousel-bullet cursor-pointer block text-4xl text-gray-400 hover:text-gray-900">•</label>
                </li>
                <li class="inline-block mr-3">
                    <label for="carousel-3" class="carousel-bullet cursor-pointer block text-4xl text-gray-400 hover:text-gray-900">•</label>
                </li>
            </ol>

        </div>
    </div>

    {{-- mostrar libros de la base de datos --}}

    <section class="bg-white py-8">
        <div class="max-w-screen-xl px-4 py-12 mx-auto sm:px-6 lg:px-8 b">

           <div class="grid grid-cols-1 gap-3 mt-4 sm:grid-cols-2 lg:grid-cols-5">
                {{-- seccion de libros --}}
                @foreach ($books as $book)
                    <a
                    href="/product/build-your-own-drone"
                    class="relative block bg-white border border-gray-200"
                    >
                    <img
                        loading="lazy"
                        alt="imagen del post {{ $book->titulo }}"
                        class="object-contain w-full h-56 lg:h-72 hover:grow hover:shadow-lg"
                        src="{{ asset('uploads').'/'.$book->imagen}}"
                    />
                        {{-- detalles de alerta --}}
                        <div class="opacity-0 w-50 bg-black text-white text-center text-sm rounded-lg py-4 absolute z-10 group-hover:opacity-100 bottom-full -left-1/4 ml-20 px-3 pointer-events-none">
                            {{ $book->titulo }}
                            <br>
                            {{ $book->author->nombre_autor }}
                        </div>

                    <div class="p-6">

                        <p class="truncate mt-2 text-xl font-medium text-dark ">
                            {{ $book->titulo }}
                        </p>

                        <h5 class="mt-4 text-lg font-bold">
                            {{ $book->author->nombre_autor }}
                        </h5>

                        <p class="mt-2 text-sm font-medium text-gray-600">
                        20 Bs
                        </p>

                        <button
                        onclick="location.href ='{{ route('books.show', $book) }}' "
                        name="add"
                        type="button"
                        class="flex items-center justify-center w-full px-8 py-4 mt-4 text-white bg-red-500  hover:bg-red-400 focus:outline-none focus:bg-red-400 rounded-sm"
                        >
                        <span class="text-sm font-medium">
                            Ver Libro
                        </span>

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>

                        </button>
                    </div>
                    </a>
                @endforeach
                {{-- fin de seccion libros --}}
          </div>
       </div>
    </section>







@endsection

{{-- diseño antiguo --}}
<section class="bg-white py-8">
    <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">
        {{-- seccion de libros --}}
        @foreach ($books as $book)
            <div class="w-full md:w-1/3 xl:w-1/5 p-6 flex flex-col" >
                <a href="#">

                    <img class="hover:grow hover:shadow-lg" alt="imagen del post {{ $book->titulo }}" src="{{ asset('uploads').'/'.$book->imagen}}">

                    <div class="group cursor-pointer relative  pt-3 w-full items-center justify-between">
                        <p class="truncate mt-2 text-xl font-medium text-dark ">
                            {{ $book->titulo }}
                        </p>
                        <p class="truncate text-left"> {{ $book->author->nombre_autor }}</p>
                        {{-- detalles de alerta --}}
                        <div class="opacity-0 w-50 bg-black text-white text-center text-sm rounded-lg py-4 absolute z-10 group-hover:opacity-100 bottom-full -left-1/4 ml-20 px-3 pointer-events-none">
                            {{ $book->titulo }}
                            <br>
                            {{ $book->author->nombre_autor }}
                        </div>

                        {{-- <svg class="h-6 w-6 fill-current text-gray-500 hover:text-black"  viewBox="0 0 24 24">
                            <path d="M12,4.595c-1.104-1.006-2.512-1.558-3.996-1.558c-1.578,0-3.072,0.623-4.213,1.758c-2.353,2.363-2.352,6.059,0.002,8.412 l7.332,7.332c0.17,0.299,0.498,0.492,0.875,0.492c0.322,0,0.609-0.163,0.792-0.409l7.415-7.415 c2.354-2.354,2.354-6.049-0.002-8.416c-1.137-1.131-2.631-1.754-4.209-1.754C14.513,3.037,13.104,3.589,12,4.595z M18.791,6.205 c1.563,1.571,1.564,4.025,0.002,5.588L12,18.586l-6.793-6.793C3.645,10.23,3.646,7.776,5.205,6.209 c0.76-0.756,1.754-1.172,2.799-1.172s2.035,0.416,2.789,1.17l0.5,0.5c0.391,0.391,1.023,0.391,1.414,0l0.5-0.5 C14.719,4.698,17.281,4.702,18.791,6.205z" />
                        </svg>--}}

                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-3xl font-bold text-gray-900 ">Bs 20</span>
                    </div>

                    <button  onclick="location.href ='{{ route('books.show', $book) }}' " class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-400 focus:outline-none focus:bg-red-400">
                        <span class="mx-1">Ver Libro</span>
                    </button>


                    {{-- <button class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-700 focus:outline-none focus:bg-red-700">
                        <svg class="w-5 h-5 mx-1" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                        </svg>
                        <span class="mx-1">Añadir Compra</span>
                    </button> --}}
                </a>
            </div>
        @endforeach
        {{-- fin de seccion de libro --}}
    </div>
</section>

{{-- fin de diseño antiguo --}}
{{-- caja de prueba --}}

                {{-- <a
                  href="/product/build-your-own-drone"
                  class="relative block bg-white border border-gray-200"
                >
                  <button
                    type="button"
                    name="wishlist"
                    class="absolute p-2 text-white bg-black rounded-full right-4 top-4"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                  </button>

                  <img
                    loading="lazy"
                    alt="Build Your Own Drone"
                    class="object-contain w-full h-56 lg:h-72"
                    src="https://www.hyperui.dev/photos/toy-1.jpeg"
                  />

                  <div class="p-6">
                    <span class="inline-block px-3 py-1 text-xs font-medium bg-yellow-400">
                      New
                    </span>

                    <h5 class="mt-4 text-lg font-bold">
                      Build Your Own Drone
                    </h5>

                    <p class="mt-2 text-sm font-medium text-gray-600">
                      $14.99
                    </p>

                    <button
                      name="add"
                      type="button"
                      class="flex items-center justify-center w-full px-8 py-4 mt-4 bg-yellow-500 rounded-sm"
                    >
                      <span class="text-sm font-medium">
                        Add to Cart
                      </span>

                      <svg class="w-5 h-5 ml-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                      </svg>
                    </button>
                  </div>
                </a> --}}


{{-- barra de navegacion antigua --}}

<header class="p-5 border-b bg-sky-800 shadow ">
    <div class="container mx-auto flex justify-between items-center ">
         <h1 class="text-3xl font-black text-gray-200">
             <a href="{{route('home')}}" class="text-3xl font-black">
                 Biblioteca
             </a>
         </h1>


             <!-- Barra de Busqueda -->
         <div class="sm:px-28 lg:px-46 xl:px-40 mx-auto w-5/6">
             <div class="box-wrapper">
                 <div class=" bg-white rounded flex items-center w-full p-3 shadow-sm border border-gray-200">
                     <input type="search" name="" id="" placeholder="Buscar libro por palabra clave / titulo / autor " x-model="q" class="w-full pl-4 text-sm outline-none focus:outline-none bg-transparent">
                     <button  class="outline-none focus:outline-none"><svg class=" w-5 text-gray-600 h-5 cursor-pointer" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
                 </div>
             </div>
         </div>

         {{-- verificacion de autenticacion de usuario --}}
         @auth
             <nav class="flex gap-2 items-center ">
                 <a class="font-bold text-gray-200" href="#">
                     Hola: <span class="font-normal">
                         {{auth()->user()->name}}
                         </span>
                 </a>

                 <a class="font-bold text-gray-200" href="{{route('books.index')}}">
                         Dashboard<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                         </svg>
                 </a>


                 {{-- metodo para cerrar sesion --}}
                 <form action="{{route('logout')}}" method="POST">
                     @csrf
                     <button type="submit" class="font-bold uppercase text-gray-200 "  >Cerrar Sesión</button>
                 </form>

             </nav>
         @endauth

         @guest
             <nav class="w-1/3 flex gap-2 items-center text-base justify-end">
                 <a class="font-bold text-left text-gray-200 " href="{{route('register')}}">Crear Cuenta</a>
                 <a class="font-bold text-left text-gray-200" href="{{route('login')}}">Login</a>
             </nav>
         @endguest

    </div>



     <div class="max-w-6xl mx-auto px-4">
         <div class="flex justify-between">
             <h1 class="text-3xl font-black text-gray-200 pt-2">
                 <div class="flex space-x-7">
                     <div>
                         <!-- Categoria Libros Populares -->
                         <a href="{{route('home')}}" class="flex items-center py-4 px-2">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                               </svg>
                             <span class="font-bold text-lg pl-2">Libros Populares</span>
                         </a>
                     </div>

                     <div>
                         <!-- Categoria Libros Mas leidos-->
                         <a href="{{route('home')}}" class="flex items-center py-4 px-2">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                               </svg>
                             <span class="font-bold text-lg pl-2">Mas Leidos</span>
                         </a>
                     </div>

                     <div>
                         <!-- Categoria Libros Recomendados -->
                         <a href="{{route('home')}}" class="flex items-center py-4 px-2">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                             </svg>
                             <span class="font-bold text-lg pl-2">Recomendados</span>
                         </a>
                     </div>

                     <div>
                         <!-- Categoria novedades -->
                         <a href="{{route('home')}}" class="flex items-center py-4 px-2">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                               </svg>
                             <span class="font-bold text-lg pl-2">Novedades</span>
                         </a>
                     </div>

                     <div>
                         <!-- Categoria Ofertas -->
                         <a href="{{route('home')}}" class="flex items-center py-4 px-2">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                               </svg>
                             <span class="font-bold text-lg pl-2">Ofertas</span>
                         </a>
                     </div>


                 </div>
             </h1>
         </div>
     </div>

 </header>



 {{-- para ver errores  --}}
 @if($errors->any())
    <div class="alert alert-danger">
        <p><strong>Opps Something went wrong</strong></p>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif



{{-- rediseño de la pagina 1 --}}

<nav class="flex items-center justify-between flex-wrap bg-teal-500 p-6">
    <div class="flex items-center flex-shrink-0 text-white mr-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
          </svg>
               <span class="font-semibold text-xl tracking-tight">MyBook</span>
    </div>
    <div class="block lg:hidden">
      <button class="flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400 hover:text-white hover:border-white">
        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
      </button>

    </div>
    <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
      <div class="text-sm lg:flex-grow">

        <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4">
        Books
        </a>
        <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white">
          Blog
        </a>
        <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white ml-4">
          About us
        </a>
      </div>
      <div>
        <div class="pt-2 relative mx-auto text-gray-600">
            <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
              type="search" name="search" placeholder="Search">
            <button type="submit" class="absolute right-0 top-0 mt-5 mr-4">
              <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
                width="512px" height="512px">
                <path
                  d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
              </svg>
            </button>
          </div>
           </div>
    </div>
  </nav>


  {{-- rediseño de la pagina 2 --}}

  <script src="//unpkg.com/alpinejs" defer></script>
<nav
class="z-0 relative"
x-data="{open:false,menu:false, lokasi:false}">
  <div class="relative z-10 bg-yellow-300 shadow">
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
      <div class="relative flex items-center justify-between h-16">
        <div class="flex items-center px-2 lg:px-0">
          <a class="flex-shrink-0" href="#">
            <img class="block lg:hidden h-12 w-16" src="https://imlovefood.com/wp-content/themes/mypanganthema/img/logo_small.png" alt="Logo">
            <img class="hidden lg:block h-12 w-auto" src="https://imlovefood.com/wp-content/themes/mypanganthema/img/logo_small_gray.png" alt="Logo">
          </a>
          <div class="hidden lg:block lg:ml-2">
            <div class="flex">
              <a href="#" class="ml-4 px-3 py-2 rounded-md text-sm leading-5 font-medium text-gray-800 font-semibold hover:bg-yellow-500 hover:text-white transition duration-150 ease-in-out cursor-pointer focus:outline-none focus:text-white focus:bg-gray-700 "> Location </a>
              <a href="#" class="ml-4 px-3 py-2 rounded-md text-sm leading-5 font-medium text-gray-800 font-semibold hover:bg-yellow-500 hover:text-white transition duration-150 ease-in-out cursor-pointer focus:outline-none focus:text-white focus:bg-gray-700 "> Article </a>
              <a href="#" class="ml-4 px-3 py-2 rounded-md text-sm leading-5 font-medium text-gray-800 font-semibold hover:bg-yellow-500 hover:text-white transition duration-150 ease-in-out cursor-pointer focus:outline-none focus:text-white focus:bg-gray-700 "> Recipe </a>
              <a href="#" class="ml-4 px-3 py-2 rounded-md text-sm leading-5 font-medium text-gray-800 font-semibold hover:bg-yellow-500 hover:text-white transition duration-150 ease-in-out cursor-pointer focus:outline-none focus:text-white focus:bg-gray-700 "> Promo </a>
            </div>
          </div>
        </div>
        <div class="flex-1 flex justify-center px-2 lg:ml-6 lg:justify-end">
          <div class="max-w-lg w-full lg:max-w-xs">
            <label for="search" class="sr-only">Search </label>
            <form methode="get" action="#" class="relative z-50">
              <button type="submit" id="searchsubmit" class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
              </button>
              <input type="text" name="s" id="s" class="block w-full pl-10 pr-3 py-2 border border-transparent rounded-md leading-5 bg-yellow-200 text-gray-300 placeholder-gray-400 focus:outline-none focus:bg-white focus:text-gray-900 sm:text-sm transition duration-150 ease-in-out" placeholder="Search">
            </form>
          </div>
        </div>
        <div class="flex lg:hidden">
          <button @click="menu=!menu" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out" aria-label="Main menu" aria-expanded="false">
            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>
    <div x-show="menu" class="block md:hidden">
      <div class="px-2 pt-2 pb-3">
        <a href="#" class="mt-1 block px-3 py-2 rounded-md text-white font-semibold font-medium hover:bg-yellow-500 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Location </a>
        <a href="#" class="mt-1 block px-3 py-2 rounded-md text-white font-semibold font-medium hover:bg-yellow-500 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Article </a>
        <a href="#" class="mt-1 block px-3 py-2 rounded-md text-white font-semibold font-medium hover:bg-yellow-500 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Recipe </a>
        <a href="#" class="mt-1 block px-3 py-2 rounded-md text-white font-semibold font-medium hover:bg-yellow-500 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Promo </a>
      </div>
    </div>
  </div>
</nav>











<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Chnage Password') }}</div>

                <form action="{{ route('update-password') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="oldPasswordInput" class="form-label">Old Password</label>
                            <input name="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput"
                                placeholder="Old Password">
                            @error('old_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="newPasswordInput" class="form-label">New Password</label>
                            <input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput"
                                placeholder="New Password">
                            @error('new_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="confirmNewPasswordInput" class="form-label">Confirm New Password</label>
                            <input name="new_password_confirmation" type="password" class="form-control" id="confirmNewPasswordInput"
                                placeholder="Confirm New Password">
                        </div>

                    </div>

                    <div class="card-footer">
                        <button class="btn btn-success">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
