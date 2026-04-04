@extends('layouts.layout')

@section('content')

@include('components.propis.subheader', ['titol' => 'Comunitats'])


<div class="max-w-5xl mx-auto overflow-auto mt-16 p-1   rounded ">
<div class="flex flex-row justify-between items-center">
    <a href="{{ route('comunitats.create') }}"><button class="cursor-pointer border  border-gray-500 bg-gray-100 text-gray-500 p-2 rounded-lg">Crear Comunitat</button></a>
</div>
</div>

<div class="max-w-5xl mx-auto overflow-auto p-2 rounded ">
    <table class="table-auto border-collapse border-1 border-gray-100 text-center w-full mx-auto ">
        <thead>
            <tr>
                <th class="border border-gray-300 text-white p-1 bg-gray-700">Nom</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($comunitats as $comunitat) {{-- // recorrer les comunitats, es com un foreach. --}}
            <tr>
                <td class="border border-gray-300 p-2 bg-gray-50">{{ $comunitat->nom }}</td>
            </tr>
            @empty
            <tr>
                <td class="border border-gray-300 p-4 text-gray-500" colspan="1">No hi ha comunitats encara.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection