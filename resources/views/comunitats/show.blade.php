@extends('layouts.layout')

@section('content')

    @include('components.propis.subheader', ['titol' => 'Comunitat ' . $comunitat->nom])

    <div class="flex flex-row max-w-6xl mx-auto mt-10 justify-start items-center">
        <a href="{{ route('comunitats.index') }}">
            <div
                class="flex flex-row p-2 justify-start items-center border border-gray-300 shadow-lg bg-gray-100 hover:text-gray-00 rounded-lg">
                <h1>Tornar a les altres comunitats</h1>
            </div>
        </a>
    </div>

    <div
        class="flex flex-row max-w-6xl bg-gray-200 mx-auto mt-4 border border-gray-300  rounded-lg p-4 justify-start items-center shadow-sm">
        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-600">
            <span class="text-blue-500">Comunitat</span> {{ $comunitat->nom }}
        </h1>
    </div>
    <div class="grid grid-cols-2 gap-4 max-w-6xl mx-auto mt-3">
        <div class="p-5 border border-gray-300 rounded-lg shadow-sm bg-white">
            <h2 class="text-lg font-bold text-slate-800">Descripció</h2>
            <p class="mt-2 text-slate-600 leading-relaxed">
                {{ $comunitat->descripcio ?? 'Sense descripció' }}
            </p>
        </div>
        <div class="bg-blue-500 border border-gray-300 rounded-lg shadow-sm">
            @if ($comunitat->imatge)
                <img src="{{ asset('storage/' . $comunitat->imatge) }}" alt="{{ $comunitat->nom }}"
                    class="h-full w-full object-cover">
            @else
                <div class="flex h-full w-full items-center justify-center text-sm text-slate-500">Sense imatge</div>
            @endif
        </div>
    </div>

    <div class="max-w-6xl mt-3  mx-auto overflow-hidden rounded-lg border border-gray-300">
        <div class="bg-slate-200 px-4 py-3">
          <h2 class="text-lg font-extrabold tracking-tight text-slate-700">
            Jugadors de la Comunitat
          </h2>
        </div>
        <div class="p-2">
          <table class="w-full  table-fixed">
            <thead>
              <tr>
                <th class="w-1/3 px-4 py-2 text-left">Nom</th>
                <th class="w-1/3 px-4 py-2 text-left">Nivell</th>
                <th class="w-1/3 px-4 py-2 text-left">Insignies</th>
              </tr>
            </thead>
            <tbody>
                @forelse($usuaris as $usuari)
                    <tr class="border-t border-slate-100">
                        <td class="w-1/3 px-4 py-2 text-left text-lg text-slate-700">{{ $usuari->name }}</td>
                        <td class="w-1/3 px-4 py-2 text-left text-lg text-slate-700"></td>
                        <td class="w-1/3 px-4 py-2 text-left text-lg text-slate-700"></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-4 text-slate-500">Encara no hi ha membres.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div
    class="flex flex-row max-w-6xl mx-auto mt-3 border border-gray-300  rounded-lg p-4 justify-start items-center shadow-sm">
    <h1 class="text-xl md:text-2xl font-extrabold tracking-tight text-slate-600">
        <span class="text-blue-500">Insignies de tots els membres de la Comunitat</span>
    </h1>
    <div class="grid grid-cols-2 gap-2">
        <div></div>
    </div>
</div>




@endsection