  {{-- barra de navegacion --}}
  <header class="bg-sky-700 text-white">
    <div class="container mx-auto px-4 py-5 flex items-center">

      <!-- logo -->
      <div class="mr-auto md:w-58 flex-shrink-0 hidden lg:block ">
        <a class="uppercase text-2xl font-extrabold" href={{route('home') }}>Libreria Virtual</a>
        {{-- <img class="h-8 md:h-10" src="https://i.ibb.co/98pHdFq/2021-10-27-15h51-15.png" alt="imagen de logo de la libreria virtual"> --}}
      </div>

      {{-- barra de busqueda --}}
      <div class="flex-1 flex justify-center px-2 lg:ml-6 lg:justify-start ">
        <div class="max-w-lg w-full lg:max-w-2xl ">
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
      {{-- fin de barra de busqueda --}}



      <!-- seccion de autentificacion -->

      @auth

      @endauth

      @guest

      @endguest
      <nav class="flex flex-col max-w-screen-xl px-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
          <a class="inline-block py-2 px-3 hover:bg-white hover:text-black font-bold rounded-full" href="#">
            <div class="flex items-center relative cursor-pointer whitespace-nowrap">Crear Cuenta</div>
          </a>
          <a class="inline-block py-2 px-3 hover:bg-white hover:text-black  font-bold rounded-full" href="#">
            <div class="flex items-center relative cursor-pointer whitespace-nowrap">Login</div>
          </a>
          {{-- <div class="block relative">
            <button type="button" class="inline-block py-2 px-3 hover:bg-gray-200 rounded-full relative ">
              <div class="flex items-center h-5">
                <div class="_xpkakx">
                  <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; height: 16px; width: 16px; fill: currentcolor;"><path d="m8.002.25a7.77 7.77 0 0 1 7.748 7.776 7.75 7.75 0 0 1 -7.521 7.72l-.246.004a7.75 7.75 0 0 1 -7.73-7.513l-.003-.245a7.75 7.75 0 0 1 7.752-7.742zm1.949 8.5h-3.903c.155 2.897 1.176 5.343 1.886 5.493l.068.007c.68-.002 1.72-2.365 1.932-5.23zm4.255 0h-2.752c-.091 1.96-.53 3.783-1.188 5.076a6.257 6.257 0 0 0 3.905-4.829zm-9.661 0h-2.75a6.257 6.257 0 0 0 3.934 5.075c-.615-1.208-1.036-2.875-1.162-4.686l-.022-.39zm1.188-6.576-.115.046a6.257 6.257 0 0 0 -3.823 5.03h2.75c.085-1.83.471-3.54 1.059-4.81zm2.262-.424c-.702.002-1.784 2.512-1.947 5.5h3.904c-.156-2.903-1.178-5.343-1.892-5.494l-.065-.007zm2.28.432.023.05c.643 1.288 1.069 3.084 1.157 5.018h2.748a6.275 6.275 0 0 0 -3.929-5.068z"></path></svg>
                </div>
              </div>
            </button>
          </div> --}}
      </nav>


    </div>

    <hr>

    <div class="container mx-auto px-4 py-2 flex items-center">
      <nav class="hidden xl:contents ml-8">
        <ul class="flex items-center text-sm font-bold">
          <li class="px-2 lg:px-3 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
              </svg>
             <a href="{{route('home')}}" class="truncate max-w-24 text-xl">Novedades</a>
          </li>
          <li class="px-2 lg:px-3 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
            </svg>
            <a href="{{route('home')}}" class="truncate max-w-24 text-xl">Recomendados</a>
          </li>
          <li class="px-2 lg:px-3 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
            <a href="{{route('home')}}" class="truncate max-w-24 text-xl" >Los Más Vistos</a>
          </li>
        </ul>
      </nav>
    </div>

    <hr>
</header>

segunda barra de navegacion

<nav class="bg-sky-700 text-white" x-data="{open:false}">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
      <div class="relative flex items-center justify-between h-16">

        <!-- Boton de menu Mobile  -->
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <button x-on:click="open = true" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <!--Icono para menu desplegable movil-->
            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>

        <div class="flex items-center justify-center sm:items-stretch sm:justify-start">
            {{-- logotipo --}}
          <div class="flex-shrink-0 flex items-center">
            <a class="uppercase text-xl font-extrabold" href={{route('home') }}>Libreria Virtual</a>
            {{-- <img class="block lg:hidden h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Workflow">
            <img class="hidden lg:block h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg" alt="Workflow"> --}}
          </div>
        </div>

        {{-- barra de busqueda --}}
        <div class="flex-1 flex justify-center px-2 lg:ml-6 lg:justify-start ">
            <div class="max-w-lg w-full lg:max-w-2xl ">
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
        {{-- fin de barra de busqueda --}}

        {{-- menu desplegable de icono --}}
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">

          <nav class="hidden lg:block  flex-col max-w-7xl mx-auto px-4 md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
                <a class="inline-block py-2 px-3 hover:bg-white hover:text-black font-bold rounded-full" href="#">
                  <div class="flex items-center relative cursor-pointer whitespace-nowrap">Crear Cuenta</div>
                </a>
                <a class="inline-block py-2 px-3 hover:bg-white hover:text-black  font-bold rounded-full" href="#">
                  <div class="flex items-center relative cursor-pointer whitespace-nowrap">Login</div>
                </a>
                {{-- <div class="block relative">
                  <button type="button" class="inline-block py-2 px-3 hover:bg-gray-200 rounded-full relative ">
                    <div class="flex items-center h-5">
                      <div class="_xpkakx">
                        <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; height: 16px; width: 16px; fill: currentcolor;"><path d="m8.002.25a7.77 7.77 0 0 1 7.748 7.776 7.75 7.75 0 0 1 -7.521 7.72l-.246.004a7.75 7.75 0 0 1 -7.73-7.513l-.003-.245a7.75 7.75 0 0 1 7.752-7.742zm1.949 8.5h-3.903c.155 2.897 1.176 5.343 1.886 5.493l.068.007c.68-.002 1.72-2.365 1.932-5.23zm4.255 0h-2.752c-.091 1.96-.53 3.783-1.188 5.076a6.257 6.257 0 0 0 3.905-4.829zm-9.661 0h-2.75a6.257 6.257 0 0 0 3.934 5.075c-.615-1.208-1.036-2.875-1.162-4.686l-.022-.39zm1.188-6.576-.115.046a6.257 6.257 0 0 0 -3.823 5.03h2.75c.085-1.83.471-3.54 1.059-4.81zm2.262-.424c-.702.002-1.784 2.512-1.947 5.5h3.904c-.156-2.903-1.178-5.343-1.892-5.494l-.065-.007zm2.28.432.023.05c.643 1.288 1.069 3.084 1.157 5.018h2.748a6.275 6.275 0 0 0 -3.929-5.068z"></path></svg>
                      </div>
                    </div>
                  </button>
                </div> --}}
          </nav>

          <!-- Perfil dropdown movil -->
          <div class="sm:hidden ml-3 relative" x-data="{ open: false }">
            <div>
              <button x-on:click="open = true" type="button" class=" flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 " id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                Crea tu Cuenta ¡Gratis!
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </button>
            </div>
            <div x-show="open" x-on:click.away="open = false" class="origin-top-right absolute z-10 right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
              <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Crear Cuenta</a>
              <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Login</a>
            </div>
          </div>

        </div>
      </div>

      {{-- menu de navegacion --}}
      <div class="hidden sm:block sm:ml-6">
        <div class="flex space-x-4">
          <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
          <a href="#" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Principal</a>

          <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">categorias</a>

          <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Projects</a>

          <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Calendar</a>
        </div>
      </div>
    </div>


  </nav>

