@extends('layouts.layout')


@section('content')

<div class="mx-auto mt-10 max-w-3xl px-4 sm:mt-12 sm:px-6 lg:px-8">
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-1">
            <h1 class="text-lg font-extrabold tracking-tight text-slate-800">Editar reserva</h1>
            <p class="text-sm text-slate-600">Canvia la data o l’hora (1 hora de durada).</p>
        </div>

        <form method="POST" action="{{ route('reserves.update', $reserva) }}" class="mt-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="data" class="text-sm font-semibold text-slate-700">Data</label>
                <input
                    id="data"
                    name="data"
                    type="date"
                    value="{{ old('data', $reserva->data) }}"
                    class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    required
                >
                @error('data')
                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="hora_inici" class="text-sm font-semibold text-slate-700">Hora inici</label>
                    <select
                        id="hora_inici"
                        name="hora_inici"
                        class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        required
                    >
                        @php($horaActual = old('hora_inici', substr((string) $reserva->hora_inici, 0, 5)))
                        @foreach(($hores ?? range(9,21)) as $h)
                            @php($val = sprintf('%02d:00', (int) $h))
                            <option value="{{ $val }}" @selected($horaActual === $val)>{{ $val }}</option>
                        @endforeach
                    </select>
                    @error('hora_inici')
                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="hora_fi" class="text-sm font-semibold text-slate-700">Hora fi</label>
                    <input
                        id="hora_fi"
                        name="hora_fi"
                        type="text"
                        value="{{ old('hora_fi', substr((string) $reserva->hora_fi, 0, 5)) }}"
                        class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-600"
                        readonly
                    >
                    @error('hora_fi')
                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                    Guardar canvis
                </button>
                <a
                    href="{{ route('reserves.index', ['data' => $reserva->data, 'comunitat_id' => $comunitatId ?? null]) }}"
                    class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                >
                    Tornar
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    (function () {
        const inici = document.getElementById('hora_inici');
        const fi = document.getElementById('hora_fi');
        if (!inici || !fi) return;

        function pad(n) { return String(n).padStart(2, '0'); }
        function updateFi() {
            const v = inici.value || '';
            const parts = v.split(':');
            const h = parseInt(parts[0] || '0', 10);
            const next = (h + 1) % 24;
            fi.value = pad(next) + ':00';
        }

        inici.addEventListener('change', updateFi);
        updateFi();
    })();
</script>
@endpush

@endsection