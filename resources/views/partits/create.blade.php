@extends('layouts.layout')

@section('content')
    @include('components.propis.subheader', ['titol' => 'Afegir jugadors (2 vs 2)'])

    <div class="mx-auto mt-10 max-w-3xl px-4">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            @if($reserva)
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-sm font-semibold text-slate-700">Reserva</p>
                    <p class="mt-1 text-sm text-slate-600">
                        {{ $reserva->data }} · {{ $reserva->hora_inici }} - {{ $reserva->hora_fi }} ·
                        {{ $reserva->pistes?->nom ?? ('Pista ' . $reserva->pista_id) }}
                    </p>
                </div>
            @endif

            <form method="POST" action="{{ route('partits.store') }}" class="mt-6 space-y-6">
                @csrf

                <input type="hidden" name="reserva_id" value="{{ $reserva?->id }}">

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm font-semibold text-slate-700">Equip A</p>
                        <div class="mt-3 space-y-3">
                            <div>
                                <label class="text-xs font-semibold text-slate-600">Jugador 1</label>
                                <input name="nom1" value="{{ old('nom1') }}" required
                                    class="mt-1 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm text-slate-800">
                                @error('nom1') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-600">Jugador 2</label>
                                <input name="nom2" value="{{ old('nom2') }}" required
                                    class="mt-1 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm text-slate-800">
                                @error('nom2') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm font-semibold text-slate-700">Equip B</p>
                        <div class="mt-3 space-y-3">
                            <div>
                                <label class="text-xs font-semibold text-slate-600">Jugador 3</label>
                                <input name="nom3" value="{{ old('nom3') }}" required
                                    class="mt-1 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm text-slate-800">
                                @error('nom3') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-600">Jugador 4</label>
                                <input name="nom4" value="{{ old('nom4') }}" required
                                    class="mt-1 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm text-slate-800">
                                @error('nom4') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                @error('reserva_id')
                    <p class="text-sm text-red-700">{{ $message }}</p>
                @enderror

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('partits.index') }}"
                        class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Cancel·lar
                    </a>
                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                        Guardar jugadors
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

