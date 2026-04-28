@extends('layouts.layout')

@section('content')
    @include('components.propis.subheader', ['titol' => 'Editar comunitat'])

    <div class="mt-6">
        <div class="mx-auto max-w-2xl rounded-xl bg-gray-100 p-6 shadow-lg">
            <form action="{{ route('comunitats.update', $comunitat) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    <div class="flex flex-col">
                        <label for="nom" class="mb-2 font-semibold text-gray-500">Nom</label>
                        <input type="text" id="nom" name="nom" value="{{ old('nom', $comunitat->nom) }}" required
                            class="rounded-md border border-slate-200 bg-white p-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        @error('nom')
                            <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col">
                        <label for="descripcio" class="mb-2 font-semibold text-gray-500">Descripció</label>
                        <input type="text" id="descripcio" name="descripcio" value="{{ old('descripcio', $comunitat->descripcio) }}" required
                            class="rounded-md border border-slate-200 bg-white p-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        @error('descripcio')
                            <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col">
                        <label for="direccio" class="mb-2 font-semibold text-gray-500">Direcció (instal·lacions)</label>
                        <input type="text" id="direccio" name="direccio" value="{{ old('direccio', $comunitat->direccio) }}"
                            class="rounded-md border border-slate-200 bg-white p-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <input type="hidden" id="lat" name="lat" value="{{ old('lat', $comunitat->lat) }}">
                        <input type="hidden" id="lng" name="lng" value="{{ old('lng', $comunitat->lng) }}">
                        <div id="direccio-suggeriments" class="mt-2 hidden overflow-hidden rounded-md border border-slate-200 bg-white"></div>
                        <div id="direccio-map" class="mt-3 {{ $comunitat->lat && $comunitat->lng ? '' : 'hidden' }} h-56 w-full overflow-hidden rounded-lg border border-slate-200"></div>
                        @error('direccio')
                            <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('comunitats.show', $comunitat) }}"
                        class="rounded-lg border border-slate-500 bg-slate-100 px-4 py-2 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-200">
                        Cancel·lar
                    </a>
                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Guardar canvis
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        (function () {
            var input = document.getElementById('direccio');
            var latEl = document.getElementById('lat');
            var lngEl = document.getElementById('lng');
            var box = document.getElementById('direccio-suggeriments');
            var mapEl = document.getElementById('direccio-map');
            if (!input || !latEl || !lngEl || !box || !mapEl) return;

            var t = null;
            var abort = null;
            var map = null;
            var marker = null;

            function ensureMap() {
                if (map) return;
                mapEl.classList.remove('hidden');
                map = L.map(mapEl).setView([41.3851, 2.1734], 12);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap',
                }).addTo(map);
            }

            function setPoint(lat, lng) {
                ensureMap();
                if (!marker) marker = L.marker([lat, lng]).addTo(map);
                marker.setLatLng([lat, lng]);
                map.setView([lat, lng], 15);
            }

            var initialLat = parseFloat(latEl.value || '');
            var initialLng = parseFloat(lngEl.value || '');
            if (!isNaN(initialLat) && !isNaN(initialLng)) {
                setPoint(initialLat, initialLng);
            }

            function render(items) {
                if (!items.length) {
                    box.classList.add('hidden');
                    box.innerHTML = '';
                    return;
                }
                box.classList.remove('hidden');
                box.innerHTML = items.map(function (it, idx) {
                    return '<button type="button" data-idx="' + idx + '" class="block w-full text-left px-3 py-2 text-sm hover:bg-slate-50">' +
                        it.display_name + '</button>';
                }).join('');

                box.querySelectorAll('button[data-idx]').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        var it = items[parseInt(btn.getAttribute('data-idx'), 10)];
                        input.value = it.display_name;
                        latEl.value = it.lat;
                        lngEl.value = it.lng;
                        box.classList.add('hidden');
                        box.innerHTML = '';
                        setPoint(it.lat, it.lng);
                    });
                });
            }

            function search(q) {
                if (abort) abort.abort();
                abort = new AbortController();
                fetch('{{ route('geocoding.search') }}?q=' + encodeURIComponent(q), { signal: abort.signal })
                    .then(function (r) { return r.json(); })
                    .then(function (data) { render(Array.isArray(data) ? data : []); })
                    .catch(function () {});
            }

            input.addEventListener('input', function () {
                var q = (input.value || '').trim();
                latEl.value = '';
                lngEl.value = '';
                if (t) clearTimeout(t);
                if (q.length < 3) {
                    box.classList.add('hidden');
                    box.innerHTML = '';
                    return;
                }
                t = setTimeout(function () { search(q); }, 250);
            });
        })();
    </script>
@endpush