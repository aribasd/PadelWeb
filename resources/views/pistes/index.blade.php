@extends('layouts.layout')

@section('content')


@include('components.propis.subheader', ['titol' => 'Pistes'])


<div class="bg-white flex-1 p-5">

    <div class="mt-5 ml-10">
        <a href="{{ route('pistes.create') }}" class="btn-afegir"><button
                title="Add New"
                class="flex group cursor-pointer outline-none hover:rotate-90 duration-300">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="50px"
                    height="50px"
                    viewBox="0 0 24 24"
                    class="stroke-zinc-400 fill-none group-hover:fill-zinc-800 group-active:stroke-zinc-200 group-active:fill-zinc-600 group-active:duration-0 duration-300">
                    <path
                        d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z"
                        stroke-width="1.5"></path>
                    <path d="M8 12H16" stroke-width="1.5"></path>
                    <path d="M12 16V8" stroke-width="1.5"></path>
                </svg>
            </button></a>
    </div>

    <div class="flex flex-col items-center space-y-12 mt-8 min-h-64">

        @foreach ($pistes as $pista)
        <div class="flex flex-row bg-gray-300 py-4 px-4 rounded-lg gap-6 w-2/3  border border-gray-200 h-80">

            <div class="flex-1 flex flex-col justify-between">
                <div>
                    <strong class="text-2xl font-bold">{{ $pista->nom }}</strong>

                    <div class="mt-4 text-left">
                        <p><strong>Descripcio:</strong> Hola hola</p>
                        <p><strong>Doble Vidre:</strong> {{ $pista->doble_vidre ? 'Sí' : 'No' }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap mt-4">
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
        @endforeach
    </div>
</div>

@endsection