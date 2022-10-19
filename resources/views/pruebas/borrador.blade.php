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



{{-- borradores de las barras de navegaciones --}}



{{-- --------------------------------------------------------------------------------------------------- --}}
<style>
    .scroll-hidden::-webkit-scrollbar {
      height: 0px;
      background: transparent; /* make scrollbar transparent */
    }
  </style>

  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

  <header x-data="{ isOpen: false }" class="bg-white shadow">
    <nav class="container mx-auto px-6 py-3">
      <div class="flex flex-col md:flex-row md:justify-between md:items-center">
        <div class="flex justify-between items-center">
          <div class="flex items-center">
            <a class="text-gray-800 text-xl font-bold md:text-2xl hover:text-gray-700" href="#">Brand</a>

            <!-- Search input on desktop screen -->
            <div class="mx-10 hidden md:block">
              <input type="text" class="w-32 lg:w-64 px-4 py-3 leading-tight text-sm text-gray-700 bg-gray-100 rounded-md placeholder-gray-500 border border-transparent focus:outline-none focus:bg-white focus:shadow-outline focus:border-blue-400" placeholder="Search" aria-label="Search">
            </div>
          </div>

          <!-- Mobile menu button -->
          <div class="flex md:hidden">
            <button @click="isOpen = !isOpen" type="button" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600" aria-label="toggle menu">
              <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current">
                <path fill-rule="evenodd" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"></path>
              </svg>
            </button>
          </div>
        </div>

        <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
        <div class="md:flex items-center" :class="isOpen ? 'block' : 'hidden'">
          <div class="flex flex-col mt-2 md:flex-row md:mt-0 md:mx-1">
            <a class="my-1 text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline md:mx-4 md:my-0" href="#">Home</a>
            <a class="my-1 text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline md:mx-4 md:my-0" href="#">Blog</a>
            <a class="my-1 text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline md:mx-4 md:my-0" href="#">Compoents</a>
            <a class="my-1 text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline md:mx-4 md:my-0" href="#">Courses</a>
          </div>

          <div class="flex items-center py-2 -mx-1 md:mx-0">
            <a class="block w-1/2 px-3 py-2 mx-1 rounded text-center text-sm bg-gray-500 font-medium text-white leading-5 hover:bg-blue-600 md:mx-2 md:w-auto" href="#">Login</a>
            <a class="block w-1/2 px-3 py-2 mx-1 rounded text-center text-sm bg-blue-500 font-medium text-white leading-5 hover:bg-blue-600 md:mx-0 md:w-auto" href="#">Join free</a>
          </div>

          <!-- Search input on mobile screen -->
          <div class="mt-3 md:hidden">
            <input type="text" class="w-full px-4 py-3 leading-tight text-sm text-gray-700 bg-gray-100 rounded-md placeholder-gray-500 focus:outline-none focus:bg-white focus:shadow-outline" placeholder="Search" aria-label="Search">
          </div>
        </div>
      </div>

      <div class="mt-3 py-3 -mx-3 overflow-y-auto whitespace-no-wrap scroll-hidden">
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">News</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">Articles</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">Videos</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">Tricks</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">PHP</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">Laravel</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">Vue</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">React</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">Tailwindcss</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">Meraki UI</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">CPP</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">JavaScript</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">Ruby</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">Mysql</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">Pest</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">PHPUnit</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">Netlify</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">VS Code</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">PHPStorm</a>
        <a class="text-sm text-gray-700 leading-5 hover:text-blue-600 hover:underline mx-4 md:my-0" href="#">Sublime</a>
      </div>
    </nav>
  </header>
{{-- numero 2 --}}
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
{{-- numero 3 --}}

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


  /////CREATE ORDER
  // public function edit($id){
    //     $order = Order::where('id',$id)->first();

    //     $this->order_id= $id;
    //     $this->nombre_contacto = $order->nombre_contacto;
    //     $this->correo_contacto = $order->nombre_contacto;
    //     $this->telefono_contacto = $order->telefono_contacto;
    //     $this->nombre_factura = $order->nombre_factura;
    //     $this->nit_factura = $order->nit_factura;
    //     $this->tipo_pago = $order->tipo_pago;
    //     $this->costo_envio = $order->costo_envio;
    //     $this->total = $order->costo_total;
    //     $this->content = $order->content;
    //     $this->ciudad_id = $order->city_id ;
    //     $this->direccion = $order->direccion ;
    //     $this->costo_envio = $order->costo_envio ;

    //     //Seccion guardar imagen

    //     $imagen = $order->imagen_deposito ;

    //     //uuid para el nombre del archivo unico
    //     $nombreImagen = Str::uuid() . '.' . $imagen->extension();

    //     //almacenar la imagen en el servidor
    //     $imagenServidor = Image::make($imagen);

    //     //efectos de intervention image
    //     $imagenServidor->fit(750,1050);

    //     $imagenPath = public_path('depositos').'/'. $nombreImagen;
    //     //solo guarda la ruta en la base de datos y no la imagen
    //     $imagenServidor->save($imagenPath);

    //     // fin de seccion guardar imagen

    //     //guardar ruta de la imagen en la base de datos
    //     $order->imagen_deposito = $nombreImagen;
    // }

    // public function update()
    // {
    //     $rules = $this->rules;

    //     $this->validate($rules);
    //     $order = Order::find($this->order_id);
    //     $order->user_id = auth()->user()->id;
    //     $order->nombre_contacto = $this->nombre_contacto;
    //     $order->telefono_contacto = $this->telefono_contacto;
    //     $order->nombre_factura = $this->nombre_factura;
    //     $order->nit_factura = $this->nit_factura;
    //     $order->tipo_pago = $this->tipo_pago;
    //     $order->costo_envio = 0;
    //     $order->total = $this->costo_envio + Cart::subtotal();
    //     $order->content = Cart::content();
    //     // si se selecciona el envio a domicilio se guarda los siguienes datos
    //     $order->city_id = $this->ciudad_id;
    //     $order->direccion = $this->direccion;
    //     $order->costo_envio = $this->costo_envio;


    //     //Seccion guardar imagen

    //     $imagen = $this->imagen_deposito;

    //     //uuid para el nombre del archivo unico
    //     $nombreImagen = Str::uuid() . '.' . $imagen->extension();

    //     //almacenar la imagen en el servidor
    //     $imagenServidor = Image::make($imagen);

    //     //efectos de intervention image
    //     $imagenServidor->fit(750,1050);

    //     $imagenPath = public_path('depositos').'/'. $nombreImagen;
    //     //solo guarda la ruta en la base de datos y no la imagen
    //     $imagenServidor->save($imagenPath);

    //     // fin de seccion guardar imagen

    //     //guardar ruta de la imagen en la base de datos
    //     $order->imagen_deposito = $nombreImagen;

    //     //guardar orden en la base de datos
    //     $order->save();

    //     //actualizar correo si es necesario
    //     $usuario = User::find(auth()->user()->id)->first();
    //     $usuario->email = $this->correo_contacto;
    //     $usuario->save();


    //     foreach (Cart::content() as $item) {
    //         descontar($item);
    //     }
    //     //limpiar carrito
    //     Cart::destroy();

    //     return redirect()->route('orders.payment',$order);
    // }
