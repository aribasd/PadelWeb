<!DOCTYPE html>
<html lang="ca">
<head>


    <meta charset="UTF-8">

{{--     <meta name="viewport" content="width=device-width, initial-scale=1.0">
 --}}    {{-- Important Activar quan fem el responsive --}}

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
          @auth
              @php
                  $navUser = auth()->user();
                  $navAvatarUrl = $navUser->avatar_path
                      ? asset('storage/' . $navUser->avatar_path)
                      : ('https://ui-avatars.com/api/?name=' . urlencode($navUser->name) . '&background=0f172a&color=ffffff&size=96');
              @endphp

              <a href="{{ route('perfils_estadistiques.index') }}" class="group flex items-center">
                  <img
                      src="{{ $navAvatarUrl }}"
                      alt="Perfil de {{ $navUser->name }}"
                      class="h-8 w-8 rounded-full object-cover transition-opacity group-hover:opacity-90"
                  />
              </a>
          @endauth
      </div>
  </div>
</nav>

<!-- CONTINGUT -->
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