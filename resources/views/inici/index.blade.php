@extends('layouts.layout')

@section('content')

    @push('vite-react')
        @vite(['resources/js/react-entry.jsx'])
    @endpush

    <div class="relative overflow-hidden bg-slate-950">
        <div class="absolute inset-0">
            <div id="home-carousel" class="relative h-[420px] w-full sm:h-[520px]">
                <div class="absolute inset-0 transition-opacity duration-700 opacity-100" data-slide="0">
                    <img
                        src="https://images.unsplash.com/photo-1646649853703-7645147474ba?auto=format&fit=crop&w=2400&q=60"
                        alt="Pista de pàdel"
                        class="h-full w-full object-cover opacity-80"
                    >
                </div>
                <div class="absolute inset-0 transition-opacity duration-700 opacity-0" data-slide="1">
                    <img
                        src="https://plus.unsplash.com/premium_photo-1708692919464-b5608dd10542?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8cGFkZWwlMjB0ZW5uaXN8ZW58MHx8MHx8fDA%3D"
                        alt="Partit de pàdel"
                        class="h-full w-full object-cover opacity-80"
                    >
                </div>
                <div class="absolute inset-0 transition-opacity duration-700 opacity-0" data-slide="2">
                    <img
                        src="https://images.unsplash.com/photo-1709587824751-dd30420f5cf3?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTU4fHxwYWRlbCUyMHRlbm5pc3xlbnwwfHwwfHx8MA%3D%3D"
                        alt="Pàdel amb amics"
                        class="h-full w-full object-cover opacity-80"
                    >
                </div>
                <div class="absolute inset-0 bg-gradient-to-r from-slate-950/85 via-slate-950/60 to-slate-950/10"></div>

                <div class="pointer-events-none absolute inset-0 flex items-center">
                    <div class="mx-auto w-full max-w-7xl px-4 py-12">
                        <div class="max-w-2xl">
                            <p class="text-sm font-semibold tracking-wide text-blue-200">SocialPadel</p>
                            <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-white sm:text-5xl">
                                Reserva, coneix gent i juga més sovint.
                            </h1>
                            <p class="mt-4 text-base text-slate-200 sm:text-lg">
                                Troba comunitats, crea amistats i organitza partits de pàdel d’una manera simple i visual.
                            </p>

                            <div class="pointer-events-auto mt-7 flex flex-wrap gap-3">
                                @guest
                                    <a href="{{ route('login') }}"
                                       class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-950">
                                        Inicia sessió
                                    </a>
                                    <a href="{{ route('register') }}"
                                       class="inline-flex items-center justify-center rounded-lg border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-white/15 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-950">
                                        Registra’t
                                    </a>
                                @endguest
                                @auth
                                    <a href="{{ route('reserves.index') }}"
                                       class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-950">
                                        Reservar ara
                                    </a>
                                    <a href="{{ route('comunitats.index') }}"
                                       class="inline-flex items-center justify-center rounded-lg border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-white/15 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-950">
                                        Explorar comunitats
                                    </a>
                                @endauth
                            </div>

                            <div class="mt-8 flex items-center gap-2 text-xs text-slate-300">
                                <span class="inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                                <span>Disponible a web (AlwaysData)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" id="carousel-prev" class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-3 text-white backdrop-blur transition hover:bg-white/20" aria-label="Anterior">
                    ‹
                </button>
                <button type="button" id="carousel-next" class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-3 text-white backdrop-blur transition hover:bg-white/20" aria-label="Següent">
                    ›
                </button>
                <div class="absolute bottom-5 left-1/2 flex -translate-x-1/2 items-center gap-2 rounded-full bg-black/30 px-3 py-2 backdrop-blur">
                    <button type="button" class="h-2 w-2 rounded-full bg-white/70" data-dot="0" aria-label="Slide 1"></button>
                    <button type="button" class="h-2 w-2 rounded-full bg-white/30" data-dot="1" aria-label="Slide 2"></button>
                    <button type="button" class="h-2 w-2 rounded-full bg-white/30" data-dot="2" aria-label="Slide 3"></button>
                </div>
            </div>
        </div>
        <div class="h-[160px] sm:h-[520px]"></div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-12">
        <div class="grid gap-6 md:grid-cols-3">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-blue-700">Reserves</p>
                <p class="mt-2 text-slate-700">Consulta disponibilitat per franges i reserva pistes dins la teva comunitat.</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-blue-700">Comunitats</p>
                <p class="mt-2 text-slate-700">Uneix-te a comunitats, comparteix i organitza’t per jugar més sovint.</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-blue-700">Progrés</p>
                <p class="mt-2 text-slate-700">Guanya XP, puja de nivell i aconsegueix insígnies per la teva activitat.</p>
            </div>
        </div>
    </div>

    <div class="bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 py-12">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-extrabold tracking-tight text-slate-800">Comunitats</h2>
                    <p class="mt-1 text-slate-600">Troba gent i instal·lacions a prop teu.</p>
                </div>
                <a href="{{ route('comunitats.index') }}" class="text-sm font-semibold text-blue-700 hover:underline">
                    Veure totes
                </a>
            </div>

            <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($comunitats as $c)
                    <a href="{{ route('comunitats.show', $c) }}" class="group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="h-36 w-full bg-slate-200 sm:h-44">
                            @if($c->imatge ?? null)
                                @php
                                    $src = \Illuminate\Support\Str::startsWith($c->imatge, ['http://', 'https://'])
                                        ? $c->imatge
                                        : asset('storage/' . $c->imatge);
                                @endphp
                                <img src="{{ $src }}" alt="{{ $c->nom }}" class="h-full w-full object-cover transition group-hover:scale-[1.02]">
                            @else
                                <div class="flex h-full w-full items-center justify-center text-sm text-slate-500">Sense imatge</div>
                            @endif
                        </div>
                        <div class="p-4">
                            <p class="font-semibold text-slate-800">{{ $c->nom }}</p>
                            <p class="mt-1 text-sm text-slate-600">{{ $c->descripcio }}</p>
                            <p class="mt-3 text-xs text-slate-500">{{ $c->direccio ?? 'Sense direcció' }}</p>
                        </div>
                    </a>
                @empty
                    <div class="rounded-xl border border-slate-200 bg-white p-6 text-slate-600">
                        Encara no hi ha comunitats creades.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        (function () {
            var root = document.getElementById('home-carousel');
            if (!root) return;

            var slides = root.querySelectorAll('[data-slide]');
            var dots = root.querySelectorAll('[data-dot]');
            var prev = document.getElementById('carousel-prev');
            var next = document.getElementById('carousel-next');
            var idx = 0;
            var timer = null;

            function setActive(i) {
                idx = (i + slides.length) % slides.length;
                slides.forEach(function (el, j) {
                    el.classList.toggle('opacity-100', j === idx);
                    el.classList.toggle('opacity-0', j !== idx);
                });
                dots.forEach(function (el, j) {
                    el.classList.toggle('bg-white/70', j === idx);
                    el.classList.toggle('bg-white/30', j !== idx);
                });
            }

            function start() {
                stop();
                timer = setInterval(function () {
                    setActive(idx + 1);
                }, 6000);
            }

            function stop() {
                if (timer) clearInterval(timer);
                timer = null;
            }

            if (prev) prev.addEventListener('click', function () { setActive(idx - 1); start(); });
            if (next) next.addEventListener('click', function () { setActive(idx + 1); start(); });
            dots.forEach(function (d) {
                d.addEventListener('click', function () {
                    var i = parseInt(d.getAttribute('data-dot'), 10);
                    setActive(i);
                    start();
                });
            });

            setActive(0);
            start();
        })();
    </script>
@endpush