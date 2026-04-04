@extends('layouts.layout')

@section('content')

    @push('vite-react')
        @vite(['resources/js/galeria-app.jsx'])
    @endpush

    @include('components.propis.subheader', ['titol' => 'Galeria'])

    {{-- Contenidor React: scroll suau (Lenis) + graella sticky; imatges demo (Unsplash) --}}
    <div id="galeria-root" class="w-full"></div>

@endsection
