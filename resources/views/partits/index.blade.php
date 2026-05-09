@extends('layouts.layout')


@section('content')


@include('components.propis.subheader', ['titol' => 'Historial de partits'])

<div class="mx-auto mt-6 max-w-5xl px-4 sm:px-6 lg:px-8">
    <div class="flex items-start gap-3 rounded-lg border border-amber-200 bg-amber-50 p-3 text-amber-800 sm:p-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 size-5 shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008Zm9-3.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <p class="text-sm">
            <span class="font-semibold">Avís:</span>
            si elimines una <span class="font-semibold">reserva</span> des d’aquesta pantalla,
            també s’eliminarà el <span class="font-semibold">partit</span> que hi tingui associat.
            Si només vols treure el partit i mantenir la reserva, fes servir el botó
            <span class="font-semibold">“Eliminar partit”</span>.
        </p>
    </div>
</div>

<div class="mx-auto mt-6 grid max-w-5xl gap-3 px-4 sm:mt-8 sm:gap-4 sm:px-6 lg:px-8">
    @forelse($reserves as $reserva)
    @php
        $esMevaReserva = auth()->check() && (int) ($reserva->user_id ?? 0) === (int) auth()->id();
    @endphp
    <div class="rounded-lg border border-slate-200 bg-slate-100 p-3 text-slate-500 shadow-sm sm:p-4 sm:shadow-lg">
            <div class="grid grid-cols-1 gap-3 bg-gray-100 p-2 sm:grid-cols-3 sm:gap-0 sm:p-0 sm:min-h-40">
                <div class="space-y-2">
                    <div>
                        <p class="text-xs font-semibold text-slate-600 sm:text-sm">Hora de Joc</p>
                        <p class="text-xs sm:text-sm">
                            {{ $reserva->hora_inici }} - {{ $reserva->hora_fi }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold text-slate-600 sm:text-sm">Pista</p>
                        <p class="text-xs sm:text-sm">{{ $reserva->pistes?->nom ?? ('Pista ' . $reserva->pista_id) }}</p>
                    </div>
                </div>
                
                <div class="flex flex-col items-center justify-center text-xl sm:text-4xl">                   
                    @if($reserva->partits)
                        @php
                            $inici = \Carbon\Carbon::parse($reserva->data . ' ' . $reserva->hora_inici);
                            $fi = \Carbon\Carbon::parse($reserva->data . ' ' . $reserva->hora_fi);
                            $ara = \Carbon\Carbon::now();
                        @endphp

                        <h1>
                            @if($ara->lt($inici))
                                Per Jugar
                            @elseif($ara->betweenIncluded($inici, $fi))
                                Jugant
                            @else
                                Partit Finalitzat
                            @endif
                        </h1>
                        <hr class="w-full border-black/40">
                    @else
                        <h1>Reserva</h1>
                        <hr class="w-full border-black/40">
                    @endif
                </div>

                <div class="flex items-start justify-start sm:justify-end">
                    <div class="text-right">
                        <p class="text-xs font-semibold text-slate-600 sm:text-sm">Data</p>
                        <p class="text-xs sm:text-sm">{{ $reserva->data }}</p>
                    </div>
                </div>
            </div>

            @if(!$reserva->partits)
                <div class="mt-3 rounded-lg border border-slate-200 bg-white p-3 sm:mt-4 sm:p-4">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-700">Jugadors (2 vs 2)</p>
                            <p class="mt-1 text-xs text-slate-500">Encara no hi ha partit creat per aquesta reserva.</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <a
                                href="{{ route('partits.create', ['reserva_id' => $reserva->id]) }}"
                                class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700 sm:px-4 sm:text-sm"
                            >
                                Afegir jugadors
                            </a>

                            @if($esMevaReserva)
                                <form
                                    method="POST"
                                    action="{{ route('reserves.destroy', $reserva) }}"
                                    onsubmit="return confirm('Vols eliminar aquesta reserva?');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="redirect_to" value="partits">
                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-red-700 sm:px-4 sm:text-sm"
                                    >
                                        Eliminar reserva
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="mt-3 grid gap-2 md:mt-4 md:grid-cols-3 md:items-center md:gap-3">
                        <div class="rounded-lg border border-slate-200 bg-slate-50 p-2 sm:p-3">
                            <p class="text-xs font-semibold text-slate-500">Equip A</p>
                            <p class="mt-1 text-xs font-semibold text-slate-700 sm:text-sm">{{ $reserva->users?->name ?? '—' }}</p>
                            <p class="text-xs text-slate-600 sm:text-sm">—</p>
                        </div>
                        <div class="text-center text-lg font-extrabold text-slate-700 md:block hidden">VS</div>
                        <div class="rounded-lg border border-slate-200 bg-slate-50 p-2 sm:p-3">
                            <p class="text-xs font-semibold text-slate-500">Equip B</p>
                            <p class="mt-1 text-xs text-slate-600 sm:text-sm">—</p>
                            <p class="text-xs text-slate-600 sm:text-sm">—</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($reserva->partits)
                @php
                    $partit = $reserva->partits;
                    $inici = \Carbon\Carbon::parse($reserva->data . ' ' . $reserva->hora_inici);
                    $fi = \Carbon\Carbon::parse($reserva->data . ' ' . $reserva->hora_fi);
                    $ara = \Carbon\Carbon::now();
                    $finalitzat = $ara->gt($fi);
                @endphp

                <div class="mt-4 rounded-lg border border-slate-200 bg-white p-4">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <p class="text-sm font-semibold text-slate-700">Jugadors</p>

                        @if($esMevaReserva)
                            <div class="flex flex-wrap items-center gap-2">
                                <form
                                    method="POST"
                                    action="{{ route('partits.destroy', $partit) }}"
                                    onsubmit="return confirm('Vols eliminar el partit? La reserva es mantindrà.');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 shadow-sm transition hover:bg-red-100"
                                    >
                                        Eliminar partit
                                    </button>
                                </form>

                                <form
                                    method="POST"
                                    action="{{ route('reserves.destroy', $reserva) }}"
                                    onsubmit="return confirm('Vols eliminar aquesta reserva? També s’eliminarà el partit.');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="redirect_to" value="partits">
                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:bg-red-700"
                                    >
                                        Eliminar reserva
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                    <div class="mt-2 grid gap-3 md:grid-cols-3 md:items-center">
                        <div class="rounded-lg border border-slate-200 bg-slate-50 p-3">
                            <p class="text-xs font-semibold text-slate-500">Equip A</p>
                            <p class="mt-1 font-semibold text-slate-800">{{ $partit->nom1 ?: ($reserva->users?->name ?? 'Jugador 1') }}</p>
                            <p class="text-sm text-slate-700">{{ $partit->nom2 ?: 'Jugador 2' }}</p>
                        </div>

                        <div class="hidden text-center text-lg font-extrabold text-slate-700 md:block">VS</div>

                        <div class="rounded-lg border border-slate-200 bg-slate-50 p-3">
                            <p class="text-xs font-semibold text-slate-500">Equip B</p>
                            <p class="mt-1 font-semibold text-slate-800">{{ $partit->nom3 ?: 'Jugador 3' }}</p>
                            <p class="text-sm text-slate-700">{{ $partit->nom4 ?: 'Jugador 4' }}</p>
                        </div>
                    </div>

                    @if($finalitzat)
                        @php
                            $guanyador = data_get($partit, 'winner_team');
                        @endphp

                        <div class="mt-4 flex flex-wrap items-center justify-between gap-2 rounded-lg border border-slate-200 bg-slate-50 p-3">
                            <p class="text-sm font-semibold text-slate-700">Guanyador</p>
                            @if((int) $guanyador === 1)
                                <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">
                                    Equip A
                                </span>
                            @elseif((int) $guanyador === 2)
                                <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">
                                    Equip B
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-700">
                                    Sense guanyador
                                </span>
                            @endif
                        </div>
                    @endif

                    @if($finalitzat)
                        <div class="mt-4">
                            <p class="text-sm font-semibold text-slate-700">Resultat (sets)</p>
                            <p class="mt-1 text-xs text-slate-500">Tria qui ha guanyat cada set (opcional) i guarda.</p>

                            <form method="POST" action="{{ route('partits.update', $partit) }}" class="mt-3">
                                @csrf
                                @method('PUT')

                                {{-- mantenim els noms per passar la validació actual --}}
                                <input type="hidden" name="nom1" value="{{ $partit->nom1 }}">
                                <input type="hidden" name="nom2" value="{{ $partit->nom2 }}">
                                <input type="hidden" name="nom3" value="{{ $partit->nom3 }}">
                                <input type="hidden" name="nom4" value="{{ $partit->nom4 }}">

                                <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                                    @foreach([1,2,3] as $s)
                                        @php $field = 'set' . $s; @endphp
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-semibold text-slate-500">Set {{ $s }}</p>
                                            <div class="mt-2 flex items-center gap-3">
                                                <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                                    <input type="radio" name="{{ $field }}" value="1" class="accent-blue-600" {{ $partit->$field ? 'checked' : '' }}>
                                                    Equip A
                                                </label>
                                                <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                                    <input type="radio" name="{{ $field }}" value="0" class="accent-blue-600" {{ ! $partit->$field ? 'checked' : '' }}>
                                                    Equip B
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-4 flex justify-end">
                                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                                        Guardar resultats
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <p class="mt-4 text-sm text-slate-600">Els sets apareixeran quan el partit estigui finalitzat.</p>
                    @endif
                </div>
            @endif
        </div>
    @empty
        <div class="rounded-lg border border-slate-200 bg-slate-50 p-6 text-slate-600">
            No hi ha reserves encara.
        </div>
    @endforelse
</div>

<div class="mx-auto mt-6 max-w-5xl px-4 sm:px-6 lg:px-8">
    {{ $reserves->links() }}
</div>



@endsection

