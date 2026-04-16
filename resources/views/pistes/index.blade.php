@extends('layouts.layout')

@section('content')

@push('vite-react')
    @vite(['resources/js/react-entry.jsx'])
@endpush

@include('components.propis.subheader', ['titol' => 'Pistes'])

<div class="flex-1 bg-white p-5">

    <div class="ml-10 mt-5 flex flex-row gap-4">
        
        <div class="flex justify-center items-center hover:text-blue-500 border border-slate-200 bg-slate-100 p-2 rounded-lg transition">
            <a href="{{  route('pistes.create') }}" class="hover:text-slate-600 text-sm font-medium text-slate-700">Crear Pistes</a>
        </div>
    </div>

    <script type="application/json" id="project-showcase-data">@json($projectShowcaseItems)</script>
    <div id="project-showcase-root" class="w-full" data-heading="Pistes"></div>

    <div class="mt-8 flex min-h-64 flex-col items-center space-y-12">

      {{--   @forelse ($pistes as $pista)
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
        @endforelse --}}
    </div>
</div>

@endsection