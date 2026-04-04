@extends('layouts.layout')

@section('content')

    @include('components.propis.subheader', ['titol' => $subheaderTitol ?? 'Comunitats'])

    <section class="bg-white lg:grid lg:h-screen lg:place-content-center dark:bg-gray-900">

        <div
            class="grid grid-cols-2 mx-auto w-screen max-w-7xl px-4 py-16 sm:px-6 sm:py-24 md:grid md:grid-cols-2 md:items-center md:gap-4 lg:px-8 lg:py-32">

            <div class="max-w-prose w-full text-left">
                <img src="https://i.pinimg.com/1200x/a9/cc/4b/a9cc4b35ec84dfe571af79e85d22ac9f.jpg" alt="Comunitat 1"
                    class="w-full h-full object-cover">

            </div>


            <div class="max-w-prose text-left">
                <h1 class="text-4xl font-bold text-gray-900 sm:text-5xl dark:text-white">
                    Understand user flow and
                    <strong class="text-indigo-600"> increase </strong>
                    conversions
                </h1>

                <p class="mt-4 text-base text-pretty text-gray-700 sm:text-lg/relaxed dark:text-gray-200">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque, nisi. Natus, provident
                    accusamus impedit minima harum corporis iusto.
                </p>

                <div class="mt-4 flex gap-4 sm:mt-6">
                    <a class="inline-block rounded border border-indigo-600 bg-indigo-600 px-5 py-3 font-medium text-white shadow-sm transition-colors hover:bg-indigo-700"
                        href="#">
                        Get Started
                    </a>

                    <a class="inline-block rounded border border-gray-200 px-5 py-3 font-medium text-gray-700 shadow-sm transition-colors hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white"
                        href="#">
                        Learn More
                    </a>
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
                        class="rounded-lg border border-slate-500 bg-slate-100 px-4 py-2 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-200">Les
                        meves comunitats</button></a>
            @endauth
            @if(($esLlistaMeves ?? false))
                <a href="{{ route('comunitats.index') }}"><button type="button"
                        class="rounded-lg border border-blue-600 bg-white px-4 py-2 text-center text-sm font-semibold text-blue-700 transition hover:bg-blue-50">Totes
                        les comunitats</button></a>
            @endif
        </div>
    </div>


    {{-- Tauler de comunitats --}}
    <div class="mx-auto grid max-w-5xl grid-cols-1 gap-4 mt-2 overflow-auto p-2 sm:grid-cols-2 justify-center items-center">
        @forelse ($comunitats as $comunitat)
            <div
                class="flex flex-col overflow-hidden rounded-lg  border-1  border-gray-300 bg-gray-50 shadow-sm shadow-slate-500">
                <div class="aspect-video w-full bg-slate-200">
                    @if ($comunitat->imatge)
                        <img src="{{ asset('storage/' . $comunitat->imatge) }}" alt="{{ $comunitat->nom }}"
                            class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center text-sm text-slate-500">Sense imatge</div>
                    @endif
                </div>
                <p class="p-3 text-lg font-semibold">Comunitat <span class="font-normal">{{ $comunitat->nom }}</span></p>

                <div class="flex flex-col bg-slate-200">

                    <p class="p-3 text-sm font-semibold">Descripció:</p>

                    <p class="text-xs p-3">{{ $comunitat->descripcio }}</p>

                </div>

                <div class="flex flex-col bg-slate-700 items-center">
                    <h1 class="text-white p-3 justify-center">Unir-se a la Comunitat</h1>
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

                    <a href="{{ route('comunitats.create') }}" class="mt-6 inline-block w-full max-w-xs">
                        <button type="button"
                            class="w-full rounded-lg bg-indigo-600 px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-indigo-700">
                            Crear comunitat
                        </button>
                    </a>
                </div>
            </div>
        @endforelse
    </div>

@endsection