@extends('layouts.layout')

@section('content')
    @include('components.propis.subheader', ['titol' => 'Perfil'])

    @php
        $perfil = $user->perfil_estadistiques;
        $nivell = $perfil ? (int) ($perfil->nivell ?? 1) : 1;
        $xp = $perfil ? (int) ($perfil->experiencia ?? 0) : 0;
        $insignies = $perfil ? $perfil->insignies : collect();

        $avatarUrl = $user->avatar_path
            ? asset('storage/' . $user->avatar_path)
            : ('https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0f172a&color=ffffff&size=256');

        $nivellService = app(\App\Services\NivellService::class);
        $prog = $perfil ? $nivellService->progressToNextLevel($perfil) : null;
    @endphp

    <div class="mt-10 max-w-3xl mx-auto rounded-lg border border-slate-200 bg-slate-50 p-6">
        <div class="flex items-center gap-5">
            <img
                src="{{ $avatarUrl }}"
                alt="Foto de perfil de {{ $user->name }}"
                class="h-20 w-20 rounded-full border border-slate-200 object-cover bg-white"
            />
            <div class="min-w-0 flex-1">
                <p class="text-xl font-semibold text-slate-800 truncate">{{ $user->name }}</p>
                @if(auth()->check() && auth()->id() === $user->id)
                    <p class="text-sm text-slate-600 truncate">{{ $user->email }}</p>
                @else
                    <p class="text-sm text-slate-500">Email ocult</p>
                @endif

                @auth
                    @if(auth()->id() !== $user->id)
                        <div class="mt-3 flex flex-wrap items-center gap-2">
                            @if(!$friendship)
                                <form method="post" action="{{ route('friendships.store') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="receiver_id" value="{{ $user->id }}" />
                                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                                        Afegir amic
                                    </button>
                                </form>
                            @elseif($friendship->status === 'pending' && $friendship->sender_id === auth()->id())
                                <span class="text-sm text-slate-600">Sol·licitud enviada</span>
                                <form method="post" action="{{ route('friendships.destroy', $friendship) }}" class="inline" onsubmit="return confirm('Vols cancel·lar la sol·licitud?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:underline">Cancel·lar</button>
                                </form>
                            @elseif($friendship->status === 'pending' && $friendship->receiver_id === auth()->id())
                                <form method="post" action="{{ route('friendships.accept', $friendship) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="rounded-lg bg-blue-600 px-3 py-1.5 text-sm text-white hover:bg-blue-700">Acceptar</button>
                                </form>
                                <form method="post" action="{{ route('friendships.decline', $friendship) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50">Declinar</button>
                                </form>
                            @elseif($friendship->status === 'accepted')
                                <span class="text-sm font-medium text-green-700">Sou amics</span>
                                <a
                                    href="{{ route('social.missatges', $user) }}"
                                    class="rounded-lg bg-slate-900 px-3 py-1.5 text-sm font-semibold text-white hover:bg-slate-800"
                                >
                                    Enviar missatge
                                </a>
                                <form method="post" action="{{ route('friendships.destroy', $friendship) }}" class="inline" onsubmit="return confirm('Eliminar amic?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-slate-600 hover:underline">Treure amic</button>
                                </form>
                            @elseif($friendship->status === 'declined')
                                <form method="post" action="{{ route('friendships.store') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="receiver_id" value="{{ $user->id }}" />
                                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                                        Tornar a enviar sol·licitud
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                    @if($errors->has('receiver_id'))
                        <p class="mt-2 text-sm text-red-600">{{ $errors->first('receiver_id') }}</p>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <div class="mt-6 max-w-3xl mx-auto rounded-lg border border-slate-200 bg-white p-6">
        <h3 class="text-lg font-semibold text-slate-800">Nivell d’usuari</h3>
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
        @endif
    </div>

    <div class="mt-6 max-w-3xl mx-auto rounded-lg border border-slate-200 bg-white p-6">
        <h3 class="text-lg font-semibold text-slate-800">Insígnies</h3>

        @if($insignies->count())
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach($insignies as $insignia)
                    <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-sm text-slate-700">
                        {{ $insignia->nom }}
                    </span>
                @endforeach
            </div>
        @else
            <p class="mt-2 text-sm text-slate-600">Aquest usuari encara no té cap insígnia.</p>
        @endif
    </div>
@endsection

