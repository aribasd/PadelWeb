@extends('layouts.layout')

@section('content')

    <div class="flex flex-col min-h-screen">
        @include('components.propis.subheader', ['titol' => 'Nova comunitat'])

        <div class="flex-1 p-5">
            <div class="max-w-lg mx-auto mt-10 rounded-xl bg-gray-100 p-2 shadow-lg">
                <form action="{{ route('comunitats.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="flex flex-col">
                        <label for="nom" class="mb-2 text-gray-500 font-semibold">Nom de la comunitat</label>
                        <input type="text" id="nom" name="nom" value="{{ old('nom') }}" maxlength="255" required
                            autocomplete="organization"
                            class="rounded-md border border-slate-300 bg-white p-2 text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600">


                        <input type="text" id="nom" name="nom" value="{{ old('nom') }}" maxlength="255" required
                            autocomplete="organization"
                            class="rounded-md border border-slate-300 bg-white p-2 text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600">

                        <label for="descripcio" class="mb-2 text-gray-500 font-semibold">Descripcio de la comunitat</label>
                        <input type="text" id="descripcio" name="descripcio" value="{{ old('descripcio') }}" maxlength="255"
                            required autocomplete="organization"
                            class="rounded-md border border-slate-300 bg-white p-2 text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>


                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                        <a href="{{ route('comunitats.index') }}"
                            class="rounded-lg border border-slate-500 bg-slate-100 px-4 py-2 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-200">
                            Cancel·lar
                        </a>
                        <button type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Crear comunitat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection