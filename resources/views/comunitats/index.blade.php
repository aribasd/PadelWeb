@extends('layouts.layout')

@section('content')

    @include('components.propis.subheader', ['titol' => $subheaderTitol ?? 'Comunitats'])

    <section class="bg-white lg:grid lg:min-h-0 lg:place-content-center dark:bg-gray-900">

        <div class="mx-auto grid w-full max-w-7xl grid-cols-1 gap-8 px-4 py-16 sm:px-6 sm:py-24 md:grid-cols-2 md:items-center md:gap-11 lg:px-8 lg:py-32">

            <div class="relative min-h-[40vh] w-full overflow-hidden rounded-xl md:min-h-[50vh] lg:min-h-0 lg:h-[min(70vh,36rem)]">
                <img src="https://i.pinimg.com/1200x/a9/cc/4b/a9cc4b35ec84dfe571af79e85d22ac9f.jpg" alt="Comunitat 1"
                    class="absolute inset-0 h-full w-full object-cover">
            </div>

            <div class="max-w-prose text-left">
                <h1 class="text-4xl font-bold text-gray-900 sm:text-5xl dark:text-white">
                    Troba la teva 
                    <strong class="text-indigo-600"> comunitat </strong>
                     de pàdel
                </h1>

                <p class="mt-4 text-base text-pretty text-gray-700 sm:text-lg/relaxed dark:text-gray-200">
                    Descobreix jugadors a prop teu, uneix-te a comunitats 
                    actives o crea la teva pròpia per organitzar partits i esdeveniments fàcilment.
                </p>

                <div class="mt-4 flex gap-4 sm:mt-6">
                    <button type="submit"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Crear comunitat
                </button>

                 {{--    <a class="inline-block rounded border border-gray-200 px-5 py-3 font-medium text-gray-700 shadow-sm transition-colors hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white"
                        href="#">
                        Learn More
                    </a> --}}

                    <a href="{{ route('comunitats.meves') }}"><button type="button"
                        class="inline-block rounded border border-gray-200 px-5 py-3 font-medium rounded-lg  text-gray-700 shadow-sm transition-colors hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Les
                        meves comunitats</button></a>
                </div>
            </div>
        </div>
    </section>

      

    <div class="mx-auto mt-16 max-w-5xl overflow-auto rounded p-1">
        <div class="flex flex-row flex-wrap items-center justify-start gap-2">
            @auth
                <a href="{{ route('comunitats.create') }}"><button type="button"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Crear
                        Comunitat</button></a>
                <a href="{{ route('comunitats.meves') }}"><button type="button"
                        class="rounded-lg border border-slate-500 bg-slate-100 px-4 py-2 text-center 
                        text-sm font-semibold text-slate-700 transition hover:bg-slate-200">Les
                        meves comunitats</button></a>
            @endauth
            @if(($esLlistaMeves ?? false))
                <a href="{{ route('comunitats.index') }}"><button type="button"
                        class="rounded-lg border border-blue-600 bg-white px-4 py-2 text-center 
                        text-sm font-semibold text-blue-700 transition hover:bg-blue-50">Totes
                        les comunitats</button></a>
            @endif
        </div>

        <form
            method="GET"
            action="{{ ($esLlistaMeves ?? false) ? route('comunitats.meves') : route('comunitats.index') }}"
            class="mt-4 flex w-full items-center gap-2"
        >
            <input
                type="text"
                name="buscador"
                value="{{ $buscador ?? request('buscador') }}"
                placeholder="Buscar comunitat per nom..."
                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm text-slate-800 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30"
            />
            <button
                type="submit"
                class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2"
            >
                Buscar
            </button>
            @if(request('buscador'))
                <a
                    href="{{ ($esLlistaMeves ?? false) ? route('comunitats.meves') : route('comunitats.index') }}"
                    class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
                >
                    Netejar
                </a>
            @endif
        </form>
    </div>


    {{-- Tauler de comunitats --}}
    <div class="mx-auto grid max-w-5xl grid-cols-1 gap-4 mt-2 overflow-auto p-2 sm:grid-cols-2 justify-center items-center">
        @forelse ($comunitats as $comunitat)
            <div
                class="flex flex-col overflow-hidden rounded-lg  border-1  border-gray-300 bg-gray-50 shadow-sm shadow-slate-500">
                <div class="h-44 w-full bg-slate-200 sm:h-52">
                    @if ($comunitat->imatge)
                        @php
                            $src = \Illuminate\Support\Str::startsWith($comunitat->imatge, ['http://', 'https://'])
                                ? $comunitat->imatge
                                : asset('storage/' . $comunitat->imatge);
                        @endphp
                        <img src="{{ $src }}" alt="{{ $comunitat->nom }}"
                            class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center text-sm text-slate-500">Sense imatge</div>
                    @endif
                </div>
                <div class="flex flex-row items-center p-1 justify-between">
                    <p class="p-1 text-lg font-semibold">Comunitat <span class="font-normal">{{ $comunitat->nom }}</span></p>
                    <p class="flex flex-row items-center">{{ $comunitat->users_count }}<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                      </svg></p>
                </div>
                <div class="flex flex-col bg-slate-200">

                    <p class="p-1 text-sm font-semibold">Descripció:</p>

                    <p class="text-xs p-3">{{ $comunitat->descripcio }}</p>

                </div>

                <div class="flex flex-row flex-wrap gap-2 p-2 items-center">   
                    @auth
                        @php
                            $jaEsMembre = in_array($comunitat->id, $mevesIds ?? [], true);
                        @endphp
                    <div>
                        
                    </div>
                        @if ($jaEsMembre)
                            <form method="GET" action="{{ route('comunitats.show', $comunitat) }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                >
                                    Veure la Comunitat
                                </button>
                            </form>
                            <form method="POST" action="{{ route('comunitats.leave', $comunitat) }}">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                >
                                    Sortir de la Comunitat
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('comunitats.join', $comunitat) }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-700 shadow-sm transition hover:bg-emerald-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                                >
                                    Unir-se a la Comunitat
                                </button>
                            </form>
                        @endif

                        @if((auth()->user()->role ?? 'user') === 'admin')
                            <form
                                method="POST"
                                action="{{ route('comunitats.destroy', $comunitat) }}"
                                onsubmit="return confirm('Vols eliminar aquesta comunitat?');"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                >
                                    Eliminar
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-white p-3 justify-center">
                            Inicia sessió per unir-te
                        </a>
                    @endauth
                </div>
            </div>
        @empty
            <div class="col-span-full flex min-h-[min(70dvh,28rem)] w-full flex-col  items-center justify-center px-4 py-12">
                <div class="mx-auto w-full max-w-md text-center bg-slate-100 border-1 p-4 border-gray-300 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="mx-auto size-20 text-gray-400" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>

                    <h2 class="mt-6 text-2xl font-bold text-gray-900">No s'ha trobat cap comunitat.</h2>

                    <p class="mt-4 text-pretty text-gray-700">
                        Crea la teva primera comunitat. Només t'hi triga uns segons.
                    </p>

                    @auth
                        @if((auth()->user()->role ?? 'user') === 'admin')
                            <a href="{{ route('comunitats.create') }}" class="mt-6 inline-block w-full max-w-xs">
                                <button type="button"
                                    class="w-full rounded-lg bg-indigo-600 px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-indigo-700">
                                    Crear comunitat
                                </button>
                            </a>
                        @else
                            <p class="mt-6 text-sm text-slate-600">
                                Només un <span class="font-semibold">administrador</span> pot crear comunitats.
                            </p>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="mt-6 inline-block w-full max-w-xs">
                            <button type="button"
                                class="w-full rounded-lg bg-indigo-600 px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-indigo-700">
                                Inicia sessió
                            </button>
                        </a>
                    @endauth
                </div>
            </div>  
        @endforelse
    </div>

    <div class="mx-auto mt-6 max-w-5xl px-2">
        {{ $comunitats->links() }}
    </div>

@endsection