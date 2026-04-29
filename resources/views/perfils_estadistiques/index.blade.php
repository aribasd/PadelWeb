@extends('layouts.layout')
@section('content')


@include('components.propis.subheader', ['titol' => 'Perfil'])

@php
    $user = auth()->user();
    $avatarUrl = $user
        ? ($user->avatar_path
            ? asset('storage/' . $user->avatar_path)
            : ('https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0f172a&color=ffffff&size=256'))
        : null;
    $amics = $user ? $user->amicsAcceptats() : collect();
    $sollicitudsPendents = $user ? $user->sollicitudsAmistatPendents() : collect();
@endphp

<div class="mt-10 max-w-3xl mx-auto rounded-lg border border-slate-200 bg-slate-50 p-6">
    @if($user)
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="shrink-0">
                @csrf
                @method('patch')

                <label for="avatar" class="group relative inline-block {{ (($user->role ?? 'user') === 'admin') ? 'cursor-pointer' : 'cursor-default' }}">
                    <img
                        src="{{ $avatarUrl }}"
                        alt="Foto de perfil de {{ $user->name }} (clic per canviar-la)"
                        title="{{ (($user->role ?? 'user') === 'admin') ? 'Clic per canviar la foto' : 'Només un administrador pot canviar la foto' }}"
                        class="h-20 w-20 rounded-full border border-slate-200 object-cover bg-white transition-opacity group-hover:opacity-90"
                    />
                    @if(($user->role ?? 'user') === 'admin')
                        <span
                            class="pointer-events-none absolute inset-0 flex items-center justify-center rounded-full bg-black/35 opacity-0 transition-opacity group-hover:opacity-100"
                            aria-hidden="true"
                        >
                            <svg viewBox="0 0 24 24" class="h-6 w-6 text-white">
                                <path
                                    fill="currentColor"
                                    d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zm2.92 2.83H5v-.92l8.06-8.06.92.92L5.92 20.08zM20.71 7.04a1.003 1.003 0 0 0 0-1.42l-2.34-2.34a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z"
                                />
                            </svg>
                        </span>
                    @endif
                </label>

                @if(($user->role ?? 'user') === 'admin')
                    <input
                        id="avatar"
                        name="avatar"
                        type="file"
                        accept="image/png,image/jpeg,image/webp"
                        class="hidden"
                        onchange="this.form.submit()"
                    />
                @endif
            </form>

            <div class="w-full min-w-0 sm:w-56 sm:shrink-0">
                <div class="flex max-h-48 flex-col overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
                    <p class="border-b border-slate-100 px-3 py-2 text-sm font-semibold text-slate-800">Amics</p>
                    <ul class="max-h-40 list-none overflow-y-auto px-2 py-1 text-sm text-slate-700">
                        @forelse($amics as $amic)
                            <li class="truncate py-1 border-b border-slate-50 last:border-0">
                                <a href="{{ route('users.show', $amic) }}" class="hover:text-blue-700 hover:underline">
                                    {{ $amic->name }}
                                </a>
                            </li>
                        @empty
                            <li class="py-3 text-center text-slate-500">Encara no tens amics. Obre el perfil d’un usuari i envia una sol·licitud.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="min-w-0 flex-1">
                <p class="text-xl font-semibold text-slate-800 truncate">{{ $user->name }}</p>
                <p class="text-sm text-slate-600 truncate">{{ $user->email }}</p>
            </div>
        </div>

        @if($sollicitudsPendents->count())
            <div class="mt-6 border-t border-slate-200 pt-4">
                <p class="text-sm font-semibold text-slate-800">Sol·licituds d’amistat pendents</p>
                <ul class="mt-2 space-y-2">
                    @foreach($sollicitudsPendents as $sol)
                        <li class="flex flex-wrap items-center justify-between gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm">
                            <span class="text-slate-700">
                                <a href="{{ route('users.show', $sol->sender) }}" class="font-medium text-slate-900 hover:underline">{{ $sol->sender->name }}</a>
                                <span class="text-slate-500"> vol ser el teu amic</span>
                            </span>
                            <span class="flex shrink-0 gap-2">
                                <form method="post" action="{{ route('friendships.accept', $sol) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="rounded bg-blue-600 px-3 py-1 text-white hover:bg-blue-700">Acceptar</button>
                                </form>
                                <form method="post" action="{{ route('friendships.decline', $sol) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="rounded border border-slate-300 bg-slate-50 px-3 py-1 text-slate-700 hover:bg-slate-100">Declinar</button>
                                </form>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    @else
        <p class="text-slate-600">Has d’iniciar sessió per veure el teu perfil.</p>
    @endif
</div>

@if($user)
    @php
        $perfil = $user->perfil_estadistiques;
        $nivell = $perfil ? (int) $perfil->nivell : 1;
        $xp = $perfil ? (int) ($perfil->experiencia ?? 0) : 0;

        $nivellService = app(\App\Services\NivellService::class);
        $prog = $perfil ? $nivellService->progressToNextLevel($perfil) : null;
    @endphp

    <div class="mt-6 max-w-3xl mx-auto rounded-lg border border-slate-200 bg-white p-6">
        <div class="flex items-center gap-2">
            <h3 class="text-lg font-semibold text-slate-800">Nivell d’usuari</h3>

            <details class="relative">
                <summary
                    class="list-none inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:text-slate-800"
                    aria-label="Informació sobre el nivell"
                    title="Informació"
                >
                    <svg viewBox="0 0 24 24" class="h-4 w-4">
                        <path
                            fill="currentColor"
                            d="M11 17h2v-6h-2v6zm1-8.75a1.25 1.25 0 1 0 0-2.5a1.25 1.25 0 0 0 0 2.5zM12 2a10 10 0 1 0 0 20a10 10 0 0 0 0-20z"
                        />
                    </svg>
                </summary>

                <div class="absolute left-0 top-10 z-10 w-80 rounded-lg border border-slate-200 bg-white p-4 text-sm text-slate-700 shadow-lg">
                    <p class="font-semibold text-slate-800">Com pujo de nivell?</p>
                    <p class="mt-2">Guanyes experiència (XP) fent accions dins la web:</p>
                    <ul class="mt-2 list-disc pl-5 text-slate-700">
                        <li>Fer una <span class="font-semibold text-slate-900">reserva</span> et dona XP.</li>
                        <li>Unir-te a una <span class="font-semibold text-slate-900">comunitat</span> també et dona XP.</li>
                    </ul>
                    <p class="mt-2 text-slate-600">Cada nivell requereix més XP que l’anterior (és progressivament més difícil).</p>
                    <p class="mt-3 text-xs text-slate-500">Tanca aquest quadre fent clic a la icona un altre cop.</p>
                </div>
            </details>
        </div>
        <div class="mt-3 flex flex-wrap items-center gap-3">
            <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-sm text-slate-700">
                Nivell <span class="ml-1 font-semibold text-slate-900">{{ $nivell }}</span>/100
            </span>
            <span class="text-sm text-slate-600">
                XP: <span class="font-semibold text-slate-800">{{ number_format($xp, 0, ',', '.') }}</span>
            </span>
        </div>

        @if($prog)
            <div class="mt-4">
                <div class="flex items-center justify-between text-xs text-slate-500">
                    <span>{{ number_format($prog['currentLevelXp'], 0, ',', '.') }} XP</span>
                    <span>{{ number_format($prog['nextLevelXp'], 0, ',', '.') }} XP</span>
                </div>
                <div class="mt-1 h-2 w-full overflow-hidden rounded-full bg-slate-100">
                    <div class="h-full bg-blue-600" style="width: {{ $prog['progress'] }}%"></div>
                </div>
                <p class="mt-2 text-sm text-slate-600">
                    Progrés al següent nivell: <span class="font-semibold text-slate-800">{{ $prog['progress'] }}%</span>
                </p>
            </div>
        @else
            <p class="mt-2 text-sm text-slate-600">Encara no tens experiència registrada.</p>
        @endif
    </div>

    <div class="mt-6 max-w-3xl mx-auto rounded-lg border border-slate-200 bg-white p-6">
        <h3 class="text-lg font-semibold text-slate-800">Insígnies</h3>

        @php $insignies = $perfil ? $perfil->insignies : collect(); @endphp

        @if($insignies->count())
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach($insignies as $insignia)
                    <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-sm text-slate-700">
                        {{ $insignia->nom }}
                    </span>
                @endforeach
            </div>
        @else
            <p class="mt-2 text-sm text-slate-600">Encara no tens cap insígnia.</p>
        @endif
    </div>
@endif

@endsection