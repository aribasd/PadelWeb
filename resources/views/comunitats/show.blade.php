@extends('layouts.layout')

@section('content')

    @include('components.propis.subheader', ['titol' => 'Comunitat ' . $comunitat->nom])

    <div class="mx-auto mt-10 flex max-w-6xl flex-wrap items-center justify-start gap-3 px-4 sm:px-0">
        <a href="{{ route('comunitats.index') }}">
            <div
                class="flex flex-row p-2 justify-start items-center border border-gray-300 shadow-lg bg-gray-100 hover:text-gray-00 rounded-lg">
                <h1>Tornar a les altres comunitats</h1>
            </div>
        </a>

        <a href="{{ route('comunitats.missatges', $comunitat) }}">
            <div
                class="flex flex-row p-2 gap-2 justify-start items-center border border-gray-300 shadow-lg  hover:text-gray-00 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                      </svg>
                      <h1>Xat de la comunitat</h1>
            </div>
        </a>
    </div>

    <div
        class="mx-auto mt-4 flex max-w-6xl flex-row justify-start rounded-lg border border-gray-300 bg-gray-200 p-4 shadow-sm">
        <div class="flex w-full items-center justify-between gap-3">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-600">
                <span class="text-blue-500">Comunitat</span> {{ $comunitat->nom }}
            </h1>
            @auth
                @if((auth()->user()->role ?? 'user') === 'admin')
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('comunitats.edit', $comunitat) }}"
                            class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Editar
                        </a>

                        <form
                            method="POST"
                            action="{{ route('comunitats.destroy', $comunitat) }}"
                            class="inline"
                            onsubmit="return confirm('Vols eliminar aquesta comunitat?');"
                        >
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
                            >
                                Eliminar
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    <div class="mx-auto mt-3 max-w-6xl rounded-lg border border-gray-300 bg-white p-4 shadow-sm">
        <div class="flex items-center justify-between gap-3">
            <h2 class="text-lg font-extrabold tracking-tight text-slate-700">Pistes de la comunitat</h2>
            @auth
                @if((auth()->user()->role ?? 'user') === 'admin')
                    <a href="{{ route('comunitats.pistes.create', $comunitat) }}"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                        Crear pista
                    </a>
                @endif
            @endauth
        </div>

        @if($comunitat->pistes->count())
            <ul class="mt-3 space-y-2">
                @foreach($comunitat->pistes as $pista)
                    <li class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">
                        <span class="font-medium text-slate-800">{{ $pista->nom }}</span>
                        <span class="text-sm text-slate-600">{{ $pista->doble_vidre ? 'Doble vidre' : 'Sense doble vidre' }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="mt-2 text-sm text-slate-600">Encara no hi ha pistes creades per aquesta comunitat.</p>
        @endif
    </div>
    <div class="mx-auto mt-3 grid max-w-6xl grid-cols-1 gap-4 px-4 sm:grid-cols-2 sm:px-0">
        <div class="p-5 border border-gray-300 rounded-lg shadow-sm bg-white">
            <h2 class="text-lg font-bold text-slate-800">Descripció</h2>
            <p class="mt-2 text-slate-600 leading-relaxed">
                {{ $comunitat->descripcio ?? 'Sense descripció' }}
            </p>
        </div>
        <div class="p-5 border border-gray-300 rounded-lg shadow-sm bg-white">
            <h2 class="text-lg font-bold text-slate-800">Direcció</h2>
            <p class="mt-2 text-slate-600 leading-relaxed">
                {{ $comunitat->direccio ?: 'Sense direcció' }}
            </p>
            @if($comunitat->lat && $comunitat->lng)
                <details class="mt-4">
                    <summary class="cursor-pointer text-sm font-semibold text-blue-700 hover:underline">
                        Veure mapa
                    </summary>
                    <div id="mapa-comunitat" class="mt-3 h-56 w-full overflow-hidden rounded-lg border border-slate-200 sm:h-72"></div>
                </details>
            @else
                <p class="mt-3 text-sm text-slate-500">No hi ha coordenades per mostrar el mapa.</p>
            @endif
        </div>
        <div class="bg-blue-500 border border-gray-300 rounded-lg shadow-sm">
            @if ($comunitat->imatge)
                <img src="{{ asset('storage/' . $comunitat->imatge) }}" alt="{{ $comunitat->nom }}"
                    class="h-full w-full object-cover">
            @else
                <div class="flex h-full w-full items-center justify-center text-sm text-slate-500">Sense imatge</div>
            @endif
        </div>
    </div>

    <div class="mx-auto mt-3 max-w-6xl overflow-hidden rounded-lg border border-gray-300">
        <div class="bg-slate-200 px-4 py-3">
            <h2 class="text-lg font-extrabold tracking-tight text-slate-700">
                Jugadors de la Comunitat
            </h2>
        </div>
        <div class="overflow-x-auto p-2">
            <table class="min-w-[520px] w-full table-fixed">
                <thead>
                    <tr>
                        <th class="w-1/3 px-4 py-2 text-left">Nom</th>
                        <th class="w-1/3 px-4 py-2 text-left">Nivell</th>
                        <th class="w-1/3 px-4 py-2 text-left">Insignies</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuaris as $usuari)
                        <tr class="border-t border-slate-100">
                            <td class="w-1/3 px-4 py-2 text-left text-lg text-slate-700">
                                <a href="{{ route('users.show', $usuari) }}" class="hover:underline">
                                    {{ $usuari->name }}
                                </a>
                            </td>
                            <td class="w-1/3 px-4 py-2 text-left text-lg text-slate-700">
                                @php $perfil = $usuari->perfil_estadistiques; @endphp
                                {{ $perfil ? ($perfil->nivell ?? 1) : 1 }}
                            </td>
                            <td class="w-1/3 px-4 py-2 text-left text-lg text-slate-700">
                                {{ $perfil ? $perfil->insignies->count() : 0 }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-slate-500">Encara no hi ha membres.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="max-w-6xl mx-auto mt-3 border border-gray-300 rounded-lg p-4 justify-start items-center shadow-sm">
        <h1 class="text-xl md:text-2xl font-extrabold tracking-tight text-slate-600">Insignies de tots els membres de la
            Comunitat</h1>

        <div class="grid grid-cols-2 gap-2 p-2 sm:grid-cols-3 lg:grid-cols-4">
            <div class="aspect-square rounded-lg border border-gray-200 bg-gray-100 p-3">
                <div class="flex h-full flex-col items-center justify-center gap-2 text-lg font-bold text-slate-600">
                    <p class="text-center">Trofeu 10 reserves</p>
                    <span class="text-6xl leading-none">🏆</span>
                    <p class="text-sm font-semibold text-slate-500">
                        Total: <span class="text-slate-700">{{ $totalTrofeu10Reserves }}</span>
                    </p>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    @if($comunitat->lat && $comunitat->lng)
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var el = document.getElementById('mapa-comunitat');
                if (!el) return;
                var lat = {{ (float) $comunitat->lat }};
                var lng = {{ (float) $comunitat->lng }};
                var map = L.map(el).setView([lat, lng], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap',
                }).addTo(map);
                L.marker([lat, lng]).addTo(map);
            });
        </script>
    @endif
@endpush