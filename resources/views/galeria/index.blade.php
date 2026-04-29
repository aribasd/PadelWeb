@extends('layouts.layout')

@section('content')

    @push('vite-react')
        @vite(['resources/js/react-entry.jsx'])
    @endpush

    @include('components.propis.subheader', ['titol' => 'Galeria'])

    {{-- Contenidor React: scroll suau (Lenis) + graella sticky; imatges demo (Unsplash) --}}
    <div id="galeria-root" class="w-full"></div>

    <div class="mx-auto mt-10 max-w-6xl px-4 pb-12">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-xl font-extrabold tracking-tight text-slate-800">Afegeix fotos a la galeria</h2>
                    <p class="mt-1 text-sm text-slate-600">Puja una imatge i es mostrarà a sota en format simple.</p>
                </div>

                @auth
                    @if((auth()->user()->role ?? 'user') === 'admin')
                    <form method="POST" action="{{ route('galeria.store') }}" enctype="multipart/form-data" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        @csrf
                        <input
                            type="file"
                            name="imatge"
                            accept="image/*"
                            class="block w-full text-sm text-slate-700 file:mr-4 file:rounded-md file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200"
                            required
                        >
                        <button
                            type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                        >
                            Pujar
                        </button>
                    </form>
                    @else
                        <div class="text-sm text-slate-600">
                            Només un <span class="font-semibold">administrador</span> pot pujar fotos a la galeria.
                        </div>
                    @endif
                @else
                    <div class="text-sm text-slate-600">
                        Has d’<a href="{{ route('login') }}" class="font-semibold text-blue-700 hover:underline">iniciar sessió</a> per pujar fotos.
                    </div>
                @endauth
            </div>

            @if($errors->has('imatge'))
                <p class="mt-3 text-sm text-red-700">{{ $errors->first('imatge') }}</p>
            @endif
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-bold text-slate-800">Fotos pujades</h3>
            <p class="mt-1 text-sm text-slate-600">Totes amb el mateix format.</p>

            <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse(($imatges ?? collect()) as $img)
                    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                        <img
                            src="{{ asset('storage/' . $img->imatge) }}"
                            alt="Foto galeria {{ $img->id }}"
                            class="h-56 w-full object-cover"
                            loading="lazy"
                        >
                    </div>
                @empty
                    <div class="rounded-xl border border-slate-200 bg-white p-6 text-sm text-slate-600">
                        Encara no hi ha cap foto pujada.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@endsection
