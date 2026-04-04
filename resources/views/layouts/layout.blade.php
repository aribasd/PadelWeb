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

</head>
<body class="flex min-h-screen flex-col font-sans antialiased">

<nav class="bg-blue-700 text-white">
  <div class="max-w-7xl mx-auto flex items-center px-2 py-3">

      <a href="inici"><h1 class="font-bold text-lg">Social<span class="text-yellow-500">Padel</span></h1></a>

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
              {{-- <x-css-profile/> --}}
          </a>
      </div>

  </div>
</nav>

<!-- CONTENIDO -->
<main class="flex-1">
    @yield('content')
</main>

@include('components.propis.footer')

{{-- Vite + React: @push des de la vista filla (després del @yield del content) --}}

{{-- COMENTARI PROPI: Serveix per poder utilitzar React a la vista Blade  exemple : @push('vite-react')
    @vite(['resources/js/react-app.jsx'])
@endpush--}}


@stack('vite-react')

</body>
</html>