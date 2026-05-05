@extends('layouts.layout')


@section('content')

<div>
{{-- 
    <div class="flex justify-center items-center hover:text-blue-500 border border-slate-200 bg-slate-100 p-2 rounded-lg transition">
        <a href="{{  route('pistes.create') }}" class="hover:text-slate-600 text-sm font-medium text-slate-700">Crear Pistes</a>
    </div>
     --}}
     
    @include('components.propis.subheader', ['titol' => 'Reserva el teu partit de Pàdel'])

    @php
    $hores = range(9, 21); // de 9:00 a 21:00
    @endphp

    @php
    $maxDia = now()->addDays(6);
    @endphp

    <div class="mx-auto mt-8 flex max-w-5xl items-center justify-end px-4 sm:mt-10 sm:px-6 lg:px-8">
        <div class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700">
            @if(!is_null($temp))
                <span class="font-semibold">{{ round($temp) }}°C</span>
                @if(!empty($descripcion))
                    <span class="text-slate-500">({{ $descripcion }})</span>
                @endif
            @else
                <span class="text-slate-500">Clima no disponible</span>
            @endif
        </div>
    </div>

    <div class="mx-4 mt-6 max-w-5xl rounded-lg border border-slate-200 bg-white p-4 sm:mx-auto sm:px-6">
        <form method="GET" action="{{ route('reserves.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <input type="hidden" name="data" value="{{ $diaIso }}">
            <div class="flex items-center gap-3">
                <label for="comunitat_id" class="text-sm font-semibold text-slate-700">Comunitat</label>
                <select
                    id="comunitat_id"
                    name="comunitat_id"
                    class="w-full max-w-xs rounded-md border border-slate-200 bg-white px-3 py-2 text-sm text-slate-800"
                    onchange="this.form.submit()"
                >
                    <option value="">Selecciona una comunitat</option>
                    @foreach($comunitatsUsuari as $c)
                        <option value="{{ $c->id }}" {{ (int) $comunitatSeleccionadaId === (int) $c->id ? 'selected' : '' }}>
                            {{ $c->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if(!$comunitatsUsuari->count())
                <p class="text-sm text-slate-600">
                    Has d’unir-te a una comunitat per poder reservar.
                    <a href="{{ route('comunitats.index') }}" class="text-blue-700 hover:underline">Veure comunitats</a>
                </p>
            @elseif(!$teAcces)
                <p class="text-sm text-slate-600">Selecciona una comunitat per veure les pistes i reservar.</p>
            @endif
        </form>
    </div>

    <div class="mx-4 mt-8 flex max-w-5xl flex-wrap items-center justify-center gap-4 py-2 sm:mx-auto sm:mt-12 sm:gap-10 sm:px-6 lg:px-8">
        @if($dia->isAfter(now(), 'day')) 
        <div class="flex justify-center items-center hover:text-blue-500 border border-slate-200 bg-slate-100 p-2 rounded-lg transition">
            <a href="{{ route('reserves.index', ['data' => $dia->copy()->subDay()->format('Y-m-d')]) }}" class="block">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
             </svg>
            </a>
        </div>
        @endif
        <div class="flex items-center justify-center rounded-lg p-2 items-center">
            <p>{{ $diaText }}</p>
        </div>
        @if($dia->lessThan($maxDia)) 
        <div class="flex justify-center items-center hover:text-blue-500 border border-slate-200 bg-slate-100 p-2 rounded-lg transition">
            <a href="{{ route('reserves.index', ['data' => $dia->copy()->addDay()->format('Y-m-d')]) }}" class="block">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                  </svg>         
            </a>
        </div>
        @endif
    </div>

    <div class="mx-auto mt-4 max-w-5xl px-0 sm:mt-6 sm:px-6 lg:px-8 {{ $teAcces ? '' : 'opacity-50 pointer-events-none select-none' }}">
        <div class="mx-4 overflow-x-auto rounded-xl border border-slate-200 bg-white p-3 sm:mx-0 sm:p-4">
            <table class="table-auto min-w-max border-collapse text-center">
            <thead>     
                <tr>
                    <th class="border border-gray-300 bg-gray-200"></th>
                    @foreach($hores as $hora)
                    <th class="border border-gray-300 bg-gray-200 p-2 text-xs font-semibold text-slate-700 sm:text-sm">{{ $hora }}:00</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($pistes as $pista)
                <tr>
                    <td class="border border-gray-300 bg-gray-100 p-2 text-left text-xs font-semibold text-slate-800 sm:text-sm"> {{ $pista->nom }}</td>
                    @foreach($hores as $hora)
                    <td class="border border-gray-300 p-3 sm:p-4">
                        @php($existeix = isset($ocupat[$pista->id][$hora]))
                        @php($tz = config('app.timezone') ?: 'Europe/Madrid')
                        @php($slot = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $diaIso . ' ' . sprintf('%02d', (int) $hora) . ':00:00', $tz))
                        @php($esPassat = $slot->lessThanOrEqualTo(\Carbon\Carbon::now($tz)))

                        @if($existeix)
                        <span class="text-red-500 bg-red-200 p-2 rounded font-bold">Ocupat</span>
                        @elseif($esPassat)
                        <span class="text-slate-400 text-sm">No disponible</span>
                        @else
                        <form action="{{ route('reserves.create') }}" method="GET">
                            <input type="hidden" name="pista_id" value="{{ $pista->id }}">
                            <input type="hidden" name="hora" value="{{ $hora }}:00">
                            <input type="hidden" name="data" value="{{ $diaIso }}">
                            <button type="submit" class="rounded bg-blue-500 px-3 py-1 text-xs font-semibold text-white hover:bg-blue-600 sm:px-6 sm:text-sm">
                                Reservar
                            </button>
                        </form>
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach

                @if(!$teAcces)
                    <tr>
                        <td colspan="{{ count($hores) + 1 }}" class="border border-gray-300 p-6 text-slate-500">
                            Selecciona una comunitat (de les teves) per poder reservar.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection