@extends('layouts.layout')


@section('content')


@include('components.propis.subheader', ['titol' => 'Historial de partits'])

<div class="mt-10 max-w-5xl mx-auto grid gap-4">
    @forelse($reserves as $reserva)
    <div class="bg-slate-100 shadow-lg text-slate-500 border border-slate-200 rounded-lg p-4">
            <div class="grid grid-cols-3 bg-gray-100 min-h-40">
                <div class="space-y-2">
                    <div>
                        <p class="text-sm font-semibold text-slate-600">Hora de Joc</p>
                        <p class="text-sm">
                            {{ $reserva->hora_inici }} - {{ $reserva->hora_fi }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-slate-600">Pista</p>
                        <p class="text-sm">{{ $reserva->pista?->nom ?? $reserva->pista_id }}</p>
                    </div>
                </div>
                
                <div class="flex flex-col justify-center text-4xl items-center">                   
                    @if($reserva->partit)
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
                        <hr class="w-full border-black">
                    @else
                        <h1>Reserva</h1>
                        <hr class="w-full border-black">
                    @endif
                </div>

                <div class="flex justify-end items-start">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-slate-600">Data</p>
                        <p class="text-sm">{{ $reserva->data }}</p>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="rounded-lg border border-slate-200 bg-slate-50 p-6 text-slate-600">
            No hi ha reserves encara.
        </div>
    @endforelse
</div>



@endsection

