@extends('layouts.layout')

@section('content')

<a href="{{ route('pistes.index') }}">Tornar a Les Pistes</a>

<div class="mt-8 flex min-h-64 flex-col items-center space-y-12">

    @forelse ($pistes as $pista)
    <div class="flex flex-row bg-gray-300 py-4 px-4 rounded-lg gap-6 w-2/3  border border-gray-200 h-80">

        <div class="flex-1 flex flex-col justify-between">
            <div>
                <strong class="text-2xl font-bold">{{ $pista->nom }}</strong>

                <div class="mt-4 text-left">
                    <p><strong>Descripcio:</strong> Hola hola</p>
                    <p><strong>Doble Vidre:</strong> {{ $pista->doble_vidre ? 'Sí' : 'No' }}</p>
                </div>
            </div>

            <div class="flex flex-wrap mt-4 gap-2">
                @include('components.propis.boto-eliminar', [
                'action' => route('pistes.destroy', $pista->id),
                'text' => 'Borrar pista'
                ])

                  @include('components.propis.boto-editar', [
                'action' => route('pistes.edit', $pista->id),
                'text' => 'Editar pista'
                ])

            </div>
        </div>

        @if($pista->imatge)
        <div class="flex-shrink-0 mr-2 w-72 h-72">
            <img src="{{ asset('storage/' . $pista->imatge) }}"
                alt="{{ $pista->nom }}"
                class="w-full h-full rounded">
        </div>
        @endif

    </div>
    @empty
        <p class="text-center text-slate-500">No hi ha cap pista encara. Crea&apos;n una amb el botó +.</p>
    @endforelse
</div>


@endsection


