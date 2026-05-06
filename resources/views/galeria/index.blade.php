@extends('layouts.layout')

@section('content')

    @include('components.propis.subheader', ['titol' => 'Galeria'])

    <div class="mx-auto mt-10 max-w-6xl px-4 pb-12">
        <div class="mb-6 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <form method="GET" action="{{ route('galeria.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div class="w-full sm:max-w-md">
                    <label for="comunitat_id" class="text-sm font-semibold text-slate-800">Filtrar per comunitat</label>
                    <select
                        id="comunitat_id"
                        name="comunitat_id"
                        class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    >
                        <option value="">Totes</option>
                        @foreach(($comunitats ?? collect()) as $c)
                            <option value="{{ $c->id }}" @selected(($comunitatId ?? null) === (int) $c->id)>{{ $c->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                        Aplicar filtre
                    </button>
                    <a href="{{ route('galeria.index') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Netejar
                    </a>
                </div>
            </form>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-xl font-extrabold tracking-tight text-slate-800">Afegeix fotos a la galeria</h2>
                    <p class="mt-1 text-sm text-slate-600">Puja una imatge i es mostrarà a sota en format simple.</p>
                </div>

                @auth
                    @if(($uploadComunitats ?? collect())->count())
                        <form method="POST" action="{{ route('galeria.store') }}" enctype="multipart/form-data" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                            @csrf
                            <select
                                name="comunitat_id"
                                class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 sm:w-56"
                                required
                            >
                                <option value="" disabled @selected(old('comunitat_id') === null)>Selecciona comunitat</option>
                                @foreach(($uploadComunitats ?? collect()) as $c)
                                    <option value="{{ $c->id }}" @selected((int) old('comunitat_id', ($comunitatId ?? 0)) === (int) $c->id)>{{ $c->nom }}</option>
                                @endforeach
                            </select>
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
                            Només els <span class="font-semibold">admins</span> d’una comunitat poden pujar fotos.
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
            @if($errors->has('comunitat_id'))
                <p class="mt-3 text-sm text-red-700">{{ $errors->first('comunitat_id') }}</p>
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
                        <div class="border-t border-slate-100 px-3 py-2 text-xs text-slate-600">
                            Comunitat: <span class="font-semibold text-slate-800">{{ $img->comunitat?->nom ?? '—' }}</span>
                        </div>
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
