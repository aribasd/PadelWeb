@extends('layouts.layout')

@section('content')

    @include('components.propis.subheader', ['titol' => 'Comunitat ' . $comunitat->nom])

    <div class="flex flex-row max-w-6xl mx-auto mt-10 gap-3 justify-start items-center">
        <a href="{{ route('comunitats.index') }}">
            <div
                class="flex flex-row p-2 justify-start items-center border border-gray-300 shadow-lg bg-gray-100 hover:text-gray-00 rounded-lg">
                <h1>Tornar a les altres comunitats</h1>
            </div>
        </a>

        <a href="{{ route('comunitats.index') }}">
            <div
                class="flex flex-row p-2 gap-2 justify-start items-center border border-gray-300 shadow-lg  hover:text-gray-00 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                      </svg>
                      <h1>Xat de la comunitat</h1>
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
                            <td class="w-1/3 px-4 py-2 text-left text-lg text-slate-700">
                                {{ ($usuari->insignies?->count() ?? 0) > 0 ? $usuari->insignies->count() : '--' }}
                            </td>
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
    </div>
    <div class="max-w-6xl mx-auto mt-3 border border-gray-300 rounded-lg p-4 justify-start items-center shadow-sm">
        <h1 class="text-xl md:text-2xl font-extrabold tracking-tight text-slate-600">Insignies de tots els membres de la
            Comunitat</h1>

        <div class="grid grid-cols-4 gap-2 p-2">
            <div class="aspect-square rounded-lg border border-gray-200 bg-gray-100 p-3">
                <div class="flex h-full flex-col items-center justify-center gap-2 text-lg font-bold text-slate-500">
                    <p class="text-center">Trofeu Veterano</p>
                    <span class="text-6xl leading-none">🏆</span>
                </div>
            </div>

            <div class="aspect-square rounded-lg border border-gray-200 bg-gray-100 p-3">
                <div class="flex h-full flex-col items-center justify-center gap-2 text-lg font-bold text-slate-500">
                    <p class="text-center">Trofeu Veterano</p>
                    <span class="text-6xl leading-none">🏆</span>
                </div>
            </div>

            <div class="aspect-square rounded-lg border border-gray-200 bg-gray-100 p-3">
                <div class="flex h-full flex-col items-center justify-center gap-2 text-lg font-bold text-slate-500">
                    <p class="text-center">Trofeu Veterano</p>
                    <span class="text-6xl leading-none">🏆</span>
                </div>
            </div>

            <div class="aspect-square rounded-lg border border-gray-200 bg-gray-100 p-3">
                <div class="flex h-full flex-col items-center justify-center gap-2 text-lg font-bold text-slate-500">
                    <p class="text-center">Trofeu Veterano</p>
                    <span class="text-6xl leading-none">🏆</span>
                </div>
            </div>


            <div class="aspect-square rounded-lg border border-gray-200 bg-gray-100 p-3">
                <div class="flex h-full flex-col items-center justify-center gap-2 text-lg font-bold text-slate-500">
                    <p class="text-center">Trofeu Veterano</p>
                    <span class="text-6xl leading-none">🏆</span>
                </div>
            </div>

        </div>
    </div>
@endsection