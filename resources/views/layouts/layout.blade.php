<!DOCTYPE html>
<html lang="ca">
<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Web</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>


    <!-- Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind necessari per mostrar-ho en el servidor -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                },
            },
        };
    </script>

    <!-- daisyUI -->
    <script type="module" src="https://unpkg.com/cally"></script>

    {{-- Necessari per React (Vite) en mode dev/HMR --}}
    @viteReactRefresh
    @stack('vite-react')

</head>

<body class="flex min-h-screen flex-col font-sans antialiased">

<nav class="relative z-50 bg-blue-700 text-white shadow-md">
  <div class="mx-auto flex max-w-7xl items-center px-2 py-3">

      <a href="{{ route('inici.index') }}"><h1 class="text-lg font-bold">Social<span class="text-yellow-500">Padel</span></h1></a>

      <div class="flex items-center gap-8 ml-20">
          <a class="hover:text-blue-200 transition" href="{{ route('pistes.index') }}">Pistes</a>
          <a class="hover:text-blue-200 transition" href="{{ route('reserves.index') }}">Reserves</a>
          <a class="hover:text-blue-200 transition" href="{{ route('partits.index') }}">Partits</a>
          <a class="hover:text-blue-200 transition" href="{{ route('galeria.index') }}">Galeria</a>
          <a class="hover:text-blue-200 transition" href="{{ route('comunitats.index') }}">Comunitats</a>
      </div>

      <div class="flex gap-5 ml-auto">
          <a href="{{ route('perfils_estadistiques.index') }}" class="flex items-center gap-2 hover:text-blue-200 transition">
              {{-- @svg('eva-message-circle-outline', ['class' => 'w-6 h-6 text-white']) --}}
          </a>

          <a class="hover:text-blue-200 transition" href="{{ route('perfils_estadistiques.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path strokeLinecap="round" strokeLinejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
              </svg>
              
          </a>
      </div>

  </div>
</nav>

<!-- CONTENIDO -->
<main class="flex-1">
    @yield('content')
</main>

@include('components.propis.footer')

{{-- Estaves carregant els entrypoints de React amb @stack('vite-react') al final del <body>.
En mode desenvolupament, React amb Vite necessita que es carregui abans 
el preamble de React Refresh (@viteReactRefresh) perquè el HMR i React funcionin correctament. --}}

@stack('scripts')

</body>
</html>