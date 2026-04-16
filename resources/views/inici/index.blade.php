@extends('layouts.layout')

@section('content')

    @push('vite-react')
        @vite(['resources/js/react-entry.jsx'])
    @endpush

    @include('components.propis.subheader', ['titol' => 'Inici'])

    <script type="application/json" id="project-showcase-data">@json($projectShowcaseItems)</script>
    <div id="project-showcase-root" class="w-full" data-heading="Les nostres pistes"></div>

@endsection