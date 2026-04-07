@extends('layouts.layout')

@section('content')

    @include('components.propis.subheader', ['titol' => $pista->nom])

    <div class="mx-auto max-w-3xl px-4 py-8">
        <a href="{{ route('pistes.index') }}" class="text-sm font-medium text-blue-700 hover:text-blue-900">
            ← Totes les pistes
        </a>

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
