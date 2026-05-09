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

                {{-- Llista compartida d'amics acceptats: serveix de suggeriment
                     per als 4 inputs, però l'usuari pot escriure el nom a mà. --}}
                <datalist id="amics-list">
                    @foreach(($amics ?? collect()) as $amic)
                        <option value="{{ $amic->name }}"></option>
                    @endforeach
                </datalist>

                @if(($amics ?? collect())->isEmpty())
                    <p class="-mt-2 text-xs text-slate-500">
                        Encara no tens amics acceptats: pots escriure els noms dels jugadors a mà.
                        Per fer-los servir directament, ves al perfil d'un usuari i envia-li sol·licitud d'amistat.
                    </p>
                @else
                    <p class="-mt-2 text-xs text-slate-500">
                        Pots <span class="font-semibold">triar un amic</span> de la llista (apareix quan cliques al camp)
                        o escriure un nom qualsevol a mà.
                    </p>
                @endif

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm font-semibold text-slate-700">Equip A</p>
                        <div class="mt-3 space-y-3">
                            <div>
                                <label class="text-xs font-semibold text-slate-600">Jugador 1</label>
                                <input name="nom1" list="amics-list" value="{{ old('nom1', $reserva?->users?->name) }}"
                                    placeholder="Nom de l'usuari de la reserva"
                                    class="mt-1 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm text-slate-800">
                                @error('nom1') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-600">Jugador 2</label>
                                <input name="nom2" list="amics-list" value="{{ old('nom2') }}"
                                    placeholder="Tria un amic o escriu un nom"
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
                                <input name="nom3" list="amics-list" value="{{ old('nom3') }}"
                                    placeholder="Tria un amic o escriu un nom"
                                    class="mt-1 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm text-slate-800">
                                @error('nom3') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-600">Jugador 4</label>
                                <input name="nom4" list="amics-list" value="{{ old('nom4') }}"
                                    placeholder="Tria un amic o escriu un nom"
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

