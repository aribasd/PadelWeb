@extends('layouts.layout')

@section('content')

@include('components.propis.subheader', ['titol' => 'Missatges'])

<div class="mx-auto mt-6 grid max-w-6xl gap-4 px-4 sm:mt-10 sm:grid-cols-3 sm:px-6 lg:px-8">
    <aside class="sm:col-span-1">
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-4 py-3">
                <p class="text-sm font-semibold text-slate-800">Amics</p>
                <p class="mt-0.5 text-xs text-slate-500">Selecciona un amic per obrir el xat</p>
            </div>

            <div class="max-h-[70vh] overflow-y-auto">
                @forelse($amics as $amic)
                    <a
                        href="{{ route('social.missatges', $amic) }}"
                        class="flex items-center justify-between gap-3 border-b border-slate-50 px-4 py-3 text-sm hover:bg-slate-50 {{ ($amicSeleccionat && $amicSeleccionat->id === $amic->id) ? 'bg-slate-50' : '' }}"
                    >
                        <span class="min-w-0 truncate font-medium text-slate-800">{{ $amic->name }}</span>
                        <span class="text-xs text-slate-400">›</span>
                    </a>
                @empty
                    <div class="px-4 py-6 text-sm text-slate-600">
                        Encara no tens amics.
                    </div>
                @endforelse
            </div>
        </div>
    </aside>

    <section class="sm:col-span-2">
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-4 py-3">
                <p class="text-sm font-semibold text-slate-800">
                    {{ $amicSeleccionat ? ('Xat amb ' . $amicSeleccionat->name) : 'Tria un amic' }}
                </p>
                <p class="mt-0.5 text-xs text-slate-500">
                    {{ $amicSeleccionat ? 'Missatges privats (només entre amics).' : 'Selecciona un amic de la llista.' }}
                </p>
            </div>

            @if(!$amicSeleccionat)
                <div class="px-4 py-10 text-sm text-slate-600">
                    No hi ha cap xat obert.
                </div>
            @else
                <div class="max-h-[55vh] space-y-3 overflow-y-auto px-4 py-4" id="bottom">
                    @forelse($missatges as $m)
                        @php($esMeu = auth()->id() === $m->emissor_id)
                        <div class="flex {{ $esMeu ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[80%] rounded-xl border border-slate-200 px-3 py-2 {{ $esMeu ? 'bg-blue-600 text-white border-blue-600' : 'bg-slate-50 text-slate-800' }}">
                                <p class="text-xs opacity-80">
                                    {{ $esMeu ? 'Tu' : ($m->emissor?->name ?? '—') }}
                                    <span class="mx-2">·</span>
                                    {{ $m->created_at?->format('Y-m-d H:i') }}
                                </p>
                                <p class="mt-1 text-sm whitespace-pre-wrap break-words">{{ $m->missatge }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-slate-500">Encara no hi ha missatges.</div>
                    @endforelse
                </div>

                <form method="POST" action="{{ route('social.missatges.store', $amicSeleccionat) }}" class="border-t border-slate-100 px-4 py-3">
                    @csrf
                    <div class="flex items-end gap-2">
                        <textarea
                            name="missatge"
                            rows="2"
                            required
                            maxlength="500"
                            class="w-full resize-none rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                            placeholder="Escriu un missatge…"
                        >{{ old('missatge') }}</textarea>
                        <button type="submit" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                            Enviar
                        </button>
                    </div>
                    @error('missatge')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </form>
            @endif
        </div>
    </section>
</div>

@endsection

