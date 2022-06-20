<nav class="bg-sky-700 text-white " x-data="{open:false}">


    <div class="relative container mx-auto flex items-star ">

        <!-- Boton de menu Mobile  -->
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden mr-2 ">
            <button x-on:click="open = true" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
            <span class="sr-only">abrir menu</span>
            <!--Icono para menu desplegable movil-->
            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            </button>
        </div>
        <!-- Fin de boton de menu Mobile  -->

        {{-- seccion de logo y titulo --}}
        <div class=" px-2 py-2  mt-2 flex-2">
            <div class="flex-shrink-0 flex items-center">
                {{-- <img class="block lg:hidden h-8 w-auto" src="{{ asset('img/logo1.png')}}" alt="Workflow"> --}}
                <img class="hidden lg:block h-8 w-auto" src="{{ asset('img/LOGOLETRA1.png')}}" alt="Workflow">
             </div>
        </div>
        {{-- barra de busqueda --}}
        <div class=" px-2 py-2 mt-2 flex-1 lg:block">
            <div class="lg:max-w-2xl sm:max-w-sm">
                <label for="search" class="sr-only">Search </label>
                <form methode="get" action="#" class="relative z-50">
                    <button type="submit" id="searchsubmit" class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                    </button>
                    <input type="text" placeholder="Buscar libro por palabra clave / titulo / autor " name="s" id="s" class="block w-full pl-10 pr-3 py-2 border border-transparent rounded-md leading-5  text-gray-300 placeholder-gray-400 focus:outline-none focus:bg-white focus:text-gray-900 sm:text-sm transition duration-150 ease-in-out" placeholder="Search">
                </form>
            </div>
        </div>
        {{-- seccion de login y registro --}}
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
        <div class=" px-2 py-2  mt-2 flex-2 hidden md:block" >
            <a class="inline-block py-2 px-3 hover:bg-white hover:text-black font-bold rounded-full" href="{{ route('register') }}">
                <div class="flex items-center relative cursor-pointer whitespace-nowrap">Crear Cuenta</div>
            </a>

            <a class="inline-block py-2 px-3 hover:bg-white hover:text-black  font-bold rounded-full" href="{{ route('login') }}">
                <div class="flex items-center relative cursor-pointer whitespace-nowrap">Login</div>
            </a>
        </div>
        @endguest

    </div>
    <hr>
    <div class="container mx-auto items-star hidden md:block">
        <div class=" px-2 py-2 mb-2 w-full items-center" >
            <ul class="flex  text-sm font-bold">
                <li class="px-2 lg:px-3 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                   <a href="{{route('home')}}" class="truncate max-w-24 ">Novedades</a>
                </li>
                <li class="px-2 lg:px-3 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                  </svg>
                  <a href="{{route('home')}}" class="truncate max-w-24 ">Recomendados</a>
                </li>
                <li class="px-2 lg:px-3 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                  </svg>
                  <a href="{{route('home')}}" class="truncate max-w-24 " >Los Más Vistos</a>
                </li>
            </ul>
        </div>
    </div>
    <hr>


     <!-- Menu movil responsivo -->
     <div class="sm:hidden" id="mobile-menu" x-show="open" x-on:click.away="open=false">
        <div class="px-2 pt-2 pb-3 space-y-1">
          <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
          <a href="{{route('home')}}" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium" aria-current="page">Crear Cuenta</a>

          <a href="{{route('home')}}" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium" aria-current="page">Login</a>
          <hr>
          <a href="{{route('home')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Principal</a>

          <a href="{{route('home')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Novedades</a>

          <a href="{{route('home')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Recomendados</a>

          <a href="{{route('home')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Los más vistos</a>
        </div>
      </div>


</nav>
