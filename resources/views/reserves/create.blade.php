@extends('layouts.layout')

@section('content')




<div class="mx-auto mt-10 max-w-lg rounded-xl bg-gray-300 p-5 shadow-lg sm:mt-12 sm:p-8">

    <h2 class="mb-4 text-2xl font-bold">Confirmar Reserva</h2>

    <p><strong>Pista:</strong> {{ $pista->nom }}</p>
    <p><strong>Data:</strong> {{ $data }}</p>
    <p><strong>Hora inici:</strong> {{ $hora_inici }}</p>
    <p><strong>Hora final:</strong> {{ $hora_fi }}</p>
    <p><strong>Precio:</strong> €{{ $preu }}</p>

    <form action="{{ route('reserves.store') }}" method="POST" class="mt-6">
        @csrf
        <input type="hidden" name="pista_id" value="{{ $pista->id }}">
        <input type="hidden" name="data" value="{{ $data }}">
        <input type="hidden" name="hora_inici" value="{{ $hora_inici }}">
        <input type="hidden" name="hora_fi" value="{{ $hora_fi }}">
        <input type="hidden" name="preu" value="{{ $preu }}">

    <button type="submit"
            class="w-full rounded-lg bg-blue-500 py-3 font-bold text-white hover:bg-blue-700">
            Confirmar Reserva
        </button>
    </form>

    <a href="{{ route('reserves.index') }}" class="mt-4 block text-center text-blue-700">Cancelar</a>

</div>

@endsection