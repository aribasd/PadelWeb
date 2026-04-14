@extends('layouts.layout')

@section('content')

<div class="mx-auto max-w-2xl px-4 py-8">
    <a href="{{ route('pistes.index') }}" class="text-sm font-medium text-blue-700 hover:text-blue-900">
        ← Tornar a les pistes
    </a>

    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="text-xl font-semibold text-slate-900">Editar pista</h1>

        @if ($errors->any())
            <div class="mt-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <form action="{{ route('pistes.update', $pista->id) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
        @csrf
        @method('PUT')

        <div class="space-y-1">
            <label for="nom" class="text-sm font-medium text-slate-700">Nom</label>
            <input
                type="text"
                name="nom"
                id="nom"
                value="{{ old('nom', $pista->nom) }}"
                class="w-full rounded-lg border border-slate-200 bg-white p-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600"
                required
            >
        </div>

        <div class="flex items-center gap-2">
            <input type="hidden" name="activa" value="0">
            <input id="activa" name="activa" type="checkbox" value="1" class="h-4 w-4 rounded border-slate-300"
                {{ old('activa', $pista->activa) ? 'checked' : '' }}>
            <label for="activa" class="text-sm text-slate-700">Activa</label>
        </div>

        <div class="flex items-center gap-2">
            <input type="hidden" name="doble_vidre" value="0">
            <input id="doble_vidre" name="doble_vidre" type="checkbox" value="1" class="h-4 w-4 rounded border-slate-300"
                {{ old('doble_vidre', $pista->doble_vidre) ? 'checked' : '' }}>
            <label for="doble_vidre" class="text-sm text-slate-700">Doble vidre</label>
        </div>

        <div class="space-y-1">
            <label for="imatge" class="text-sm font-medium text-slate-700">Imatge (opcional)</label>
            <input type="file" name="imatge" id="imatge" accept="image/*" class="block w-full text-sm text-slate-700">
        </div>

        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
            Guardar
        </button>

    </form>

    <form action="{{ route('pistes.destroy', $pista->id) }}" method="POST" class="mt-6">
        @csrf
        @method('DELETE')
        <button type="submit" class="rounded-lg bg-slate-700 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
            Eliminar Pista
        </button>
    </form>
    </div>
</div>
@endsection


