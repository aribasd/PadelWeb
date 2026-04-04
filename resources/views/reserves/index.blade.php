@extends('layouts.layout')


@section('content')

<div>

    @include('components.propis.subheader', ['titol' => 'Reserva el teu partit de Pàdel'])

    @php
    $hores = range(9, 21); // de 9:00 a 21:00
    @endphp

    <div class="w-100 h-100 bg-black">

    </div>

    <div class="max-w-5xl mx-auto overflow-auto mt-12  rounded ">
        <table class="table-auto border-collapse border-2 border-gray-300 text-center w-full mx-auto mt-10 ">
            <thead>
                <tr>
                    <th class="border border-gray-300 text-white p-2 bg-gray-400">Pistes</th>
                    @foreach($hores as $hora)
                    <th class="border border-gray-300 p-2 bg-gray-200">{{ $hora }}:00</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($pistes as $pista)
                <tr>
                    <td class="border border-gray-300 p-2 font-semibold bg-gray-200"> {{ $pista->nom }}</td>
                    @foreach($hores as $hora)
                    <td class="border border-gray-300 p-4">
                        @php
                                        $existeix = $reserves->where('pista_id', $pista->id)
                        ->filter(function($r) use ($hora) {
                            $horaText =  sprintf('%02d:00', (int) $hora);

                            return \Carbon\Carbon::parse($r->hora_inici)->format('H:i') === $horaText;
                        })
                        ->count() > 0;
                        @endphp

                        @if($existeix)
                        <span class="text-red-500 bg-red-200 p-2 rounded font-bold">Ocupat</span>
                        @else
                        <form action="{{ route('reserves.create') }}" method="GET">
                            <input type="hidden" name="pista_id" value="{{ $pista->id }}">
                            <input type="hidden" name="hora" value="{{ $hora }}:00">
                            <input type="hidden" name="data" value="{{ date('Y-m-d') }}">
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