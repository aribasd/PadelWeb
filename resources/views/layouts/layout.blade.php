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

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Necessari per React (Vite) en mode dev/HMR --}}
    @viteReactRefresh
    @stack('vite-react')

</head>

<body class="flex min-h-screen flex-col font-sans antialiased">

    <nav class="relative z-50 bg-blue-700 text-white shadow-md">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center gap-x-4 gap-y-3 px-4 py-3 sm:px-6 lg:px-8">

            <a href="{{ route('inici.index') }}">
                <h1 class="text-lg font-bold">Social<span class="text-yellow-500">Padel</span></h1>
            </a>

            <div class="order-3 w-full md:order-none md:w-auto">
                <div class="flex flex-wrap items-center gap-2 text-xs sm:gap-3 sm:text-sm md:ml-10 md:gap-4 md:text-base lg:ml-20">
                {{-- <a class="hover:text-blue-200 transition" href="{{ route('pistes.index') }}">Pistes</a>
                --}} <a class="rounded-md px-2 py-1 hover:text-blue-200 transition" href="{{ route('reserves.index') }}">Reserves</a>
                <a class="rounded-md px-2 py-1 hover:text-blue-200 transition" href="{{ route('comunitats.index') }}">Comunitats</a>
                <a class="rounded-md px-2 py-1 hover:text-blue-200 transition" href="{{ route('partits.index') }}">Historial Partits</a>
                <a class="rounded-md px-2 py-1 hover:text-blue-200 transition" href="{{ route('galeria.index') }}">Galeria</a>
                </div>
            </div>

            <div class="order-2 ml-auto flex gap-5 md:order-none">
                @auth
                    @php
                        $navUser = auth()->user();
                        $navUserId = (int) ($navUser?->id ?? 0);
                        $navAvatarUrl = $navUser->avatar_path
                            ? asset('storage/' . $navUser->avatar_path)
                            : ('https://ui-avatars.com/api/?name=' . urlencode($navUser->name) . '&background=0f172a&color=ffffff&size=96');

                        $socialQuery = (string) request('social_q', '');
                        $socialQuery = trim($socialQuery);

                        /** @var \Illuminate\Database\Eloquent\Collection<int,\App\Models\Friendship> $pendingSent */
                        $pendingSent = \App\Models\Friendship::query()
                            ->where('emissor_id', $navUserId)
                            ->where('estat', 'pending')
                            ->with('receptor')
                            ->orderByDesc('created_at')
                            ->limit(8)
                            ->get();

                        /** @var \Illuminate\Database\Eloquent\Collection<int,\App\Models\Friendship> $pendingReceived */
                        $pendingReceived = \App\Models\Friendship::query()
                            ->where('receptor_id', $navUserId)
                            ->where('estat', 'pending')
                            ->with('emissor')
                            ->orderByDesc('created_at')
                            ->limit(8)
                            ->get();

                        /** @var \Illuminate\Database\Eloquent\Collection<int,\App\Models\Friendship> $acceptedFriendships */
                        $acceptedFriendships = \App\Models\Friendship::query()
                            ->where('estat', 'accepted')
                            ->where(function ($q) use ($navUserId) {
                                $q->where('emissor_id', $navUserId)->orWhere('receptor_id', $navUserId);
                            })
                            ->with(['emissor', 'receptor'])
                            ->orderByDesc('updated_at')
                            ->limit(20)
                            ->get();

                        $socialResults = collect();
                        if ($socialQuery !== '' && mb_strlen($socialQuery) >= 3) {
                            $email = mb_strtolower($socialQuery);
                            $socialResults = \App\Models\User::query()
                                ->where('id', '!=', $navUserId)
                                ->whereRaw('LOWER(email) = ?', [$email])
                                ->limit(1)
                                ->get();
                        }
                      @endphp

                    {{-- Social dropdown --}}
                    <details class="relative">
                        <summary class="list-none cursor-pointer [&::-webkit-details-marker]:hidden" title="Social">
                            <span class="group flex items-center justify-center rounded-full bg-white/10 p-2 transition hover:bg-white/20">
                                <svg viewBox="0 0 24 24" class="h-5 w-5 text-white" aria-hidden="true">
                                    <path fill="currentColor" d="M16 11c1.66 0 3-1.34 3-3s-1.34-3-3-3s-3 1.34-3 3s1.34 3 3 3ZM8 11c1.66 0 3-1.34 3-3S9.66 5 8 5S5 6.34 5 8s1.34 3 3 3Zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13Zm8 0c-.29 0-.62.02-.97.05c1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5Z"/>
                                </svg>
                            </span>
                        </summary>

                        <div class="absolute right-0 mt-2 w-[22rem] max-w-[90vw] overflow-hidden rounded-xl border border-slate-200 bg-white text-slate-700 shadow-lg">
                            <div class="border-b border-slate-100 px-4 py-3 flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">Social</p>
                                <p class="mt-0.5 text-xs text-slate-500">Amics i sol·licituds</p>
                                </div>
                                <a
                                    href="{{ route('social.missatges') }}"
                                    class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-2.5 py-2 text-slate-700 hover:bg-slate-50"
                                    title="Missatges"
                                >
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" aria-hidden="true">
                                        <path fill="currentColor" d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2Zm0 14H5.17L4 17.17V4h16v12Z"/>
                                    </svg>
                                </a>
                            </div>

                            <div class="max-h-[70vh] overflow-y-auto px-4 py-3 space-y-4">
                                {{-- Cercar usuaris --}}
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Cercar usuari</p>
                                    <form method="GET" action="{{ request()->url() }}" class="mt-2 flex gap-2">
                                        <input
                                            type="text"
                                            name="social_q"
                                            value="{{ $socialQuery }}"
                                            placeholder="Email exacte (ex: test@example.com)"
                                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                                        />
                                        <button type="submit" class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                                            Cercar
                                        </button>
                                    </form>

                                    @if($socialQuery !== '' && mb_strlen($socialQuery) < 3)
                                        <p class="mt-2 text-xs text-slate-500">Escriu mínim 3 caràcters.</p>
                                    @endif

                                    @if($socialResults->count())
                                        <ul class="mt-2 space-y-2">
                                            @foreach($socialResults as $u)
                                                <li class="flex items-center justify-between gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">
                                                    <a href="{{ route('users.show', $u) }}" class="min-w-0 truncate text-sm font-medium text-slate-800 hover:underline">
                                                        {{ $u->name }}
                                                    </a>
                                                    <form method="POST" action="{{ route('friendships.store') }}" class="shrink-0">
                                                        @csrf
                                                        <input type="hidden" name="receiver_id" value="{{ $u->id }}">
                                                        <button type="submit" class="rounded bg-blue-600 px-3 py-1 text-xs font-semibold text-white hover:bg-blue-700">
                                                            Afegir
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @elseif($socialQuery !== '' && mb_strlen($socialQuery) >= 3)
                                        <p class="mt-2 text-xs text-slate-500">Cap usuari amb aquest email.</p>
                                    @endif
                                </div>

                                {{-- Sol·licituds rebudes --}}
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Sol·licituds rebudes</p>
                                    @if($pendingReceived->count())
                                        <ul class="mt-2 space-y-2">
                                            @foreach($pendingReceived as $fr)
                                                <li class="flex items-center justify-between gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2">
                                                    <a href="{{ route('users.show', $fr->emissor) }}" class="min-w-0 truncate text-sm font-medium text-slate-800 hover:underline">
                                                        {{ $fr->emissor?->name ?? 'Usuari' }}
                                                    </a>
                                                    <div class="flex shrink-0 gap-2">
                                                        <form method="POST" action="{{ route('friendships.accept', $fr) }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="rounded bg-blue-600 px-2 py-1 text-xs font-semibold text-white hover:bg-blue-700">Acceptar</button>
                                                        </form>
                                                        <form method="POST" action="{{ route('friendships.decline', $fr) }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="rounded border border-slate-300 bg-white px-2 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-50">Declinar</button>
                                                        </form>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="mt-2 text-xs text-slate-500">No en tens.</p>
                                    @endif
                                </div>

                                {{-- Sol·licituds enviades --}}
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Sol·licituds enviades</p>
                                    @if($pendingSent->count())
                                        <ul class="mt-2 space-y-2">
                                            @foreach($pendingSent as $fr)
                                                <li class="flex items-center justify-between gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2">
                                                    <a href="{{ route('users.show', $fr->receptor) }}" class="min-w-0 truncate text-sm font-medium text-slate-800 hover:underline">
                                                        {{ $fr->receptor?->name ?? 'Usuari' }}
                                                    </a>
                                                    <form method="POST" action="{{ route('friendships.destroy', $fr) }}" onsubmit="return confirm('Vols cancel·lar la sol·licitud?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-xs font-semibold text-red-700 hover:underline">Cancel·lar</button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="mt-2 text-xs text-slate-500">No n’hi ha.</p>
                                    @endif
                                </div>

                                {{-- Amics --}}
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Amics</p>
                                    @if($acceptedFriendships->count())
                                        <ul class="mt-2 space-y-2">
                                            @foreach($acceptedFriendships as $fr)
                                                @php
                                                    $other = ((int) $fr->emissor_id === $navUserId) ? $fr->receptor : $fr->emissor;
                                                @endphp
                                                <li class="flex items-center justify-between gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">
                                                    <a href="{{ route('users.show', $other) }}" class="min-w-0 truncate text-sm font-medium text-slate-800 hover:underline">
                                                        {{ $other?->name ?? 'Usuari' }}
                                                    </a>
                                                    <form method="POST" action="{{ route('friendships.destroy', $fr) }}" onsubmit="return confirm('Eliminar amic?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-xs font-semibold text-slate-600 hover:underline">Treure</button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="mt-2 text-xs text-slate-500">Encara no tens amics.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </details>

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