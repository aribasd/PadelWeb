@extends('layouts.layout')

@section('content')

@include('components.propis.subheader', ['titol' => $subheaderTitol ?? 'Comunitats'])


<div class="max-w-5xl mx-auto overflow-auto mt-16 p-1 rounded ">
<div class="flex flex-row flex-wrap justify-start gap-2 items-center">
    <a href="{{ route('comunitats.create') }}"><button type="button" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Crear Comunitat</button></a>

    @auth
    <a href="{{ route('comunitats.meves') }}"><button type="button" class="rounded-lg border border-slate-500 bg-slate-100 px-4 py-2 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-200">Les meves comunitats</button></a>
    @endauth

    @if(($esLlistaMeves ?? false))
    <a href="{{ route('comunitats.index') }}"><button type="button" class="rounded-lg border border-blue-600 bg-white px-4 py-2 text-center text-sm font-semibold text-blue-700 transition hover:bg-blue-50">Totes les comunitats</button></a>
    @endif
</div>

</div>


{{-- Tauler de comunitats --}}
<div class="mx-auto grid max-w-5xl grid-cols-1 gap-4 mt-2 overflow-auto p-2 sm:grid-cols-2">
    @forelse ($comunitats as $comunitat)
        <div class="flex flex-col overflow-hidden rounded-lg border border-gray-300 bg-gray-50 shadow-sm">
            <div class="aspect-video w-full bg-slate-200">
                @if ($comunitat->imatge)
                    <img src="{{ asset('storage/'.$comunitat->imatge) }}" alt="{{ $comunitat->nom }}" class="h-full w-full object-cover">
                @else
                    <div class="flex h-full w-full items-center justify-center text-sm text-slate-500">Sense imatge</div>
                @endif
            </div>
            <p class="p-3 text-lg font-semibold">Comunitat <span class="font-normal">{{ $comunitat->nom }}</span></p>
            
            <div class="flex flex-col bg-gray-200">

                <p class="p-3 text-sm font-semibold">Descripció:</p>

                <p class="text-xs p-3">{{ $comunitat->descripcio }}</p>

            </div>
  

        </div>
    @empty
        <p class="col-span-full rounded border border-gray-300 p-4 text-center text-gray-500">No hi ha comunitats encara.</p>
    @endforelse
</div>

@endsection
 