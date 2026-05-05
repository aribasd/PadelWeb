<!DOCTYPE html>
<html lang="ca">

<head>


    <meta charset="UTF-8">

    {{--
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    --}} {{-- Important Activar quan fem el responsive --}}

    <title>Padel Web</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Necessari per React (Vite) en mode dev/HMR --}}
    @viteReactRefresh
    @stack('vite-react')

</head>

<body class="flex min-h-screen flex-col font-sans antialiased">

    <nav class="relative z-50 bg-blue-700 text-white shadow-md">
        <div class="mx-auto flex max-w-7xl items-center px-2 py-3">

            <a href="{{ route('inici.index') }}">
                <h1 class="text-lg font-bold">Social<span class="text-yellow-500">Padel</span></h1>
            </a>

            <div class="flex items-center gap-8 ml-20">
                {{-- <a class="hover:text-blue-200 transition" href="{{ route('pistes.index') }}">Pistes</a>
                --}} <a class="hover:text-blue-200 transition" href="{{ route('reserves.index') }}">Reserves</a>
                <a class="hover:text-blue-200 transition" href="{{ route('comunitats.index') }}">Comunitats</a>
                <a class="hover:text-blue-200 transition" href="{{ route('partits.index') }}">Historial Partits</a>
                <a class="hover:text-blue-200 transition" href="{{ route('galeria.index') }}">Galeria</a>


            </div>

            <div class="flex gap-5 ml-auto">
                @auth
                    @php
                        $navUser = auth()->user();
                        $navAvatarUrl = $navUser->avatar_path
                            ? asset('storage/' . $navUser->avatar_path)
                            : ('https://ui-avatars.com/api/?name=' . urlencode($navUser->name) . '&background=0f172a&color=ffffff&size=96');
                      @endphp
                    <details class="relative">
                        <summary class="list-none cursor-pointer [&::-webkit-details-marker]:hidden">
                            <span class="group flex items-center">
                                <img
                                    src="{{ $navAvatarUrl }}"
                                    alt="Perfil de {{ $navUser->name }}"
                                    class="h-8 w-8 rounded-full object-cover transition-opacity group-hover:opacity-90"
                                />
                            </span>
                        </summary>

                        <div class="absolute right-0 mt-2 w-44 overflow-hidden rounded-xl border border-slate-200 bg-white text-slate-700 shadow-lg">
                            <a
                                href="{{ route('perfils_estadistiques.index') }}"
                                class="block px-4 py-2 text-sm hover:bg-slate-50"
                            >
                                Perfil
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="block w-full px-4 py-2 text-left text-sm text-red-700 hover:bg-red-50"
                                >
                                    Tancar sessió
                                </button>
                            </form>
                        </div>
                    </details>
                @endauth
            </div>
        </div>
    </nav>

    <!-- CONTINGUT -->
    <main class="flex-1">
        @yield('content')
    </main>

    @include('components.propis.footer')

    {{-- Estaves carregant els entrypoints de React amb @stack('vite-react') al final del

    <body>.
        En mode desenvolupament, React amb Vite necessita que es carregui abans
        el preamble de React Refresh (@viteReactRefresh) perquè el HMR i React funcionin correctament. --}}

        @stack('scripts')

    </body>

</html>