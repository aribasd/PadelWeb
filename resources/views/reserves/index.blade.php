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

    <div class="flex justify-end items-center mt-10 mr-20 mx-auto">
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

    <div class="flex  items-center justify-center flex-row max-w-5xl mx-auto gap-10 p-2 mt-12  rounded-lg">
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

    <div class="max-w-5xl mx-auto overflow-auto  rounded ">
        <table class="table-auto border-collapse border-2 border-gray-300 text-center w-full mx-auto mt-2 ">
            <thead>     
                <tr>
                    <th class="border border-gray-300 text-white bg-gray-200"></th>
                    @foreach($hores as $hora)
                    <th class="border border-gray-300 p-2 bg-gray-200">{{ $hora }}:00</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($pistes as $pista)
                <tr>
                    <td class="border border-gray-300 p-2 font-semibold bg-gray-100"> {{ $pista->nom }}</td>
                    @foreach($hores as $hora)
                    <td class="border border-gray-300 p-4">
                        @php($existeix = isset($ocupat[$pista->id][$hora]))

                        @if($existeix)
                        <span class="text-red-500 bg-red-200 p-2 rounded font-bold">Ocupat</span>
                        @else
                        <form action="{{ route('reserves.create') }}" method="GET">
                            <input type="hidden" name="pista_id" value="{{ $pista->id }}">
                            <input type="hidden" name="hora" value="{{ $hora }}:00">
                            <input type="hidden" name="data" value="{{ $diaIso }}">
                            <button type="submit" class="bg-blue-500 text-white px-9 py-1 rounded hover:bg-blue-600">
                                Reservar
                            </button>
                        </form>
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection