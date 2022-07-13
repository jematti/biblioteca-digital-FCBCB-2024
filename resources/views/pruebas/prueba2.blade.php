<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- hojas de estilos diferentes --}}
    @stack('styles')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Biblioteca') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .work-sans {
            font-family: 'Work Sans', sans-serif;
        }

        #menu-toggle:checked + #menu {
            display: block;
        }

        .hover\:grow {
            transition: all 0.3s;
            transform: scale(1);
        }

        .hover\:grow:hover {
            transform: scale(1.02);
        }

        .carousel-open:checked + .carousel-item {
            position: static;
            opacity: 100;
        }

        .carousel-item {
            -webkit-transition: opacity 0.6s ease-out;
            transition: opacity 0.6s ease-out;
        }

        #carousel-1:checked ~ .control-1,
        #carousel-2:checked ~ .control-2,
        #carousel-3:checked ~ .control-3 {
            display: block;
        }

        .carousel-indicators {
            list-style: none;
            margin: 0;
            padding: 0;
            position: absolute;
            bottom: 2%;
            left: 0;
            right: 0;
            text-align: center;
            z-index: 10;
        }

        #carousel-1:checked ~ .control-1 ~ .carousel-indicators li:nth-child(1) .carousel-bullet,
        #carousel-2:checked ~ .control-2 ~ .carousel-indicators li:nth-child(2) .carousel-bullet,
        #carousel-3:checked ~ .control-3 ~ .carousel-indicators li:nth-child(3) .carousel-bullet {
            color: #000;
            /*Set to match the Tailwind colour you want the active one to be */
        }
    </style>


</head>

<body class="bg-gray-200">

    <div class="space-y-4">
        <div x-data="{ activeAccordion: true }">
          <h3>
            <button
              :aria-expanded="activeAccordion"
              aria-controls="accordion-panel-1"
              @click="activeAccordion = !activeAccordion"
              class="flex items-center justify-between w-full p-6 text-white bg-black rounded-lg"
            >
              <h2>Lorem ipsum dolor sit amet consectetur adipisicing elit?</h2>

              <span
                :class="{ '-rotate-180': activeAccordion }"
                class="transition"
                aria-hidden="true"
              >
                👇
              </span>
            </button>
          </h3>

          <section
            id="accordion-panel-1"
            aria-labelledby="accordion-header-1"
            :hidden="! activeAccordion"
            class="mt-4"
          >
            <p>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. At dolorum
              tenetur aut doloribus iste? Recusandae ipsam quod modi eligendi
              perspiciatis voluptatibus fugit, similique tenetur quos quasi impedit
              totam beatae iure, dolor unde voluptas a veniam adipisci quibusdam qui
              harum vel! Dolorem quaerat delectus in dignissimos libero, beatae itaque
              repudiandae! Velit?
            </p>
          </section>
        </div>

        <div x-data="{ activeAccordion: false }">
          <h3>
            <button
              :aria-expanded="activeAccordion"
              aria-controls="accordion-panel-2"
              @click="activeAccordion = !activeAccordion"
              class="flex items-center justify-between w-full p-6 text-white bg-black rounded-lg"
            >
              <h2>Lorem ipsum dolor sit amet consectetur adipisicing elit?</h2>

              <span
                :class="{ '-rotate-180': activeAccordion }"
                class="transition"
                aria-hidden="true"
              >
                👇
              </span>
            </button>
          </h3>

          <section
            id="accordion-panel-2"
            aria-labelledby="accordion-header-2"
            class="mt-4"
            :hidden="! activeAccordion"
          >
            <p>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. At dolorum
              tenetur aut doloribus iste? Recusandae ipsam quod modi eligendi
              perspiciatis voluptatibus fugit, similique tenetur quos quasi impedit
              totam beatae iure, dolor unde voluptas a veniam adipisci quibusdam qui
              harum vel! Dolorem quaerat delectus in dignissimos libero, beatae itaque
              repudiandae! Velit?
            </p>
          </section>
        </div>
      </div>

      <div  x-data="{ service: false, handover:false, parcel:false }">

        Service<input id="service" type="checkbox" x-model="service"><br/>

        date<input name="date" id="date" type="date"
             x-bind:disabled="parcel || handover || service"
             x-bind:required="(select == 1) ? true : false"/><br/>

        Handover <input id="handover" type="checkbox" x-model="handover">  <br/>

         Parcel<input id="parcel" type="checkbox" x-model="parcel"><br/>


    </div>

</body>
<script src="{{ asset('js/app.js') }}" defer ></script>
