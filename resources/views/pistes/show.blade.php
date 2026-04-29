@extends('layouts.layout')

@section('content')

    @include('components.propis.subheader', ['titol' => $pista->nom])

    <div class="mx-auto max-w-3xl px-4 py-8">
        <a href="{{ route('pistes.index') }}" class="text-sm font-medium text-blue-700 hover:text-blue-900">
            ← Totes les pistes
        </a>

        @auth
            @if((auth()->user()->role ?? 'user') === 'admin')
                <div class="mt-4 flex flex-wrap gap-2">
                    <a
                        href="{{ route('pistes.edit', $pista) }}"
                        class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                    >
                        Editar
                    </a>

                    <form
                        method="POST"
                        action="{{ route('pistes.destroy', $pista) }}"
                        class="inline"
                        onsubmit="return confirm('Vols eliminar aquesta pista?');"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
                        >
                            Eliminar pista
                        </button>
                    </form>
                </div>
            @endif
        @endauth

        <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="font-semibold text-slate-700">Nom</dt>
                    <dd class="text-slate-900">{{ $pista->nom }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-700">Doble vidre</dt>
                    <dd class="text-slate-900">{{ $pista->doble_vidre ? 'Sí' : 'No' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-700">Estat</dt>
                    <dd class="text-slate-900">{{ $pista->activa ? 'Activa' : 'Inactiva' }}</dd>
                </div>
            </dl>

            @if ($pista->imatge)
                <div class="mt-6">
                    <img
                        src="{{ asset('storage/' . $pista->imatge) }}"
                        alt="{{ $pista->nom }}"
                        class="max-h-96 w-full rounded-lg object-cover"
                    />
                </div>
            @endif
        </div>
    </div>

@endsection
