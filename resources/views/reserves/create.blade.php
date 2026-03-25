@extends('layouts.layout')

@section('content')




<div class="max-w-lg mx-auto mt-12 p-8 bg-gray-300 rounded-xl shadow-lg">

    <h2 class="text-2xl font-bold mb-4">Confirmar Reserva</h2>

    <p><strong>Pista:</strong> {{ $pista->nom }}</p>
    <p><strong>Fecha:</strong> {{ $data }}</p>
    <p><strong>Hora inicio:</strong> {{ $hora_inici }}</p>
    <p><strong>Hora fin:</strong> {{ $hora_fi }}</p>
    <p><strong>Precio:</strong> €{{ $preu }}</p>

    <form action="{{ route('reserves.store') }}" method="POST" class="mt-6">
        @csrf
        <input type="hidden" name="pista_id" value="{{ $pista->id }}">
        <input type="hidden" name="data" value="{{ $data }}">
        <input type="hidden" name="hora_inici" value="{{ $hora_inici }}">
        <input type="hidden" name="hora_fi" value="{{ $hora_fi }}">
        <input type="hidden" name="preu" value="{{ $preu }}">

        <button type="submit"
            class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 rounded-lg">
            Confirmar Reserva
        </button>
    </form>

    <a href="{{ route('reserves.index') }}" class="block mt-4 text-center text-blue-700">Cancelar</a>

</div>

@endsection