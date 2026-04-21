@extends('layouts.layout')

@section('content')



    @include('components.propis.subheader', ['titol' => $comunitat->nom])

    <div class="mx-auto flex min-h-screen w-full max-w-5xl flex-col rounded-lg  p-4">
        <div class="mb-4 flex items-center justify-start">
            <form method="GET" action="{{ route('comunitats.show', $comunitat) }}">
                @csrf
                <button type="submit" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-slate-500 shadow-lg">
                    Tornar a la Comunitat
                </button>
            </form>
        </div>

        <div class="flex-1 overflow-hidden rounded-lg p-4">
            @if($missatges->hasMorePages())
                <div class="mb-4 flex justify-center">
                    <a href="{{ $missatges->nextPageUrl() }}"
                       class="rounded bg-blue-600 px-4 py-2 text-sm font-semibold text-white">
                        Cargar Més Missatges
                    </a>
                </div>
            @endif

            <div class="h-full max-h-[60vh] space-y-3 overflow-y-auto pr-2">
                @forelse($missatges->getCollection()->reverse() as $missatge)
                    @php($esMeu = auth()->check() && $missatge->user_id === auth()->id())

                    <div class="flex {{ $esMeu ? 'justify-start' : 'justify-end' }}">
                        <div class="max-w-[75%] rounded-lg border border-slate-200 p-3 {{ $esMeu ? 'bg-slate-200' : 'bg-slate-100' }}">
                            <div class="text-sm text-slate-600">
                                {{ $missatge->user?->name ?? '—' }}
                                <span class="mx-2">·</span>
                                {{ $missatge->created_at?->format('Y-m-d H:i') ?? '' }}
                            </div>
                            <div class="mt-1 text-slate-800">
                                {{ $missatge->missatge }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-slate-500">Encara no hi ha missatges.</div>
                @endforelse
            </div>
        </div>
@auth
<form class="mt-4" action="{{ route('comunitats.missatges.store', $comunitat) }}" method="POST">
    @csrf
    <div class="flex flex-row items-center gap-4">
        <textarea class="w-full resize-none rounded-full border border-slate-300 p-2" rows="2" name="missatge" id="missatge" placeholder="Escriu un missatge" required></textarea>
        <button class="rounded-full bg-blue-600 px-6 py-4 font-semibold text-white" type="submit"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
          </svg>
          </button>
    </div>
</form>
@endauth
   
    </div>

@endsection