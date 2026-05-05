@extends('layouts.layout')

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-10">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Dashboard</h1>

            @if(!($isAdmin ?? false))
                <div class="mt-4 rounded-lg border border-amber-200 bg-amber-50 p-4 text-amber-900">
                    No pots entrar al dashboard si no ets <span class="font-semibold">admin</span>.
                </div>
            @else
                <p class="mt-4 text-slate-700">
                    Estàs connectat.
                </p>
            @endif
        </div>
    </div>
@endsection
