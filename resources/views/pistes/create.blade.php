@extends('layouts.layout')

@section('content')


<div class="flex flex-col min-h-screen">

    <!-- Header -->
    <div class="flex items-center h-20 bg-gray-700">


        <h1 class="text-white text-2xl font-bold ml-10">Afegir Nova Pista</h1>

    </div>

    <div class="bg-gray-300 flex-1 p-5">
        <div class="max-w-lg mx-auto bg-gray-800 p-8 rounded-xl shadow-lg mt-10">

            <form action="{{ route('pistes.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf

                <!-- Nom de la pista -->
                <div class="flex flex-col">
                    <label for="nom" class="mb-2 text-white font-semibold">Nom de la pista</label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required
                        class="p-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Doble Vidre -->
                <div class="flex flex-col">
                    <label for="doble_vidre" class="mb-2 text-white font-semibold">Doble Vidre</label>
                    <select id="doble_vidre" name="doble_vidre" required
                        class="p-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="1" {{ old('doble_vidre') == "1" ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ old('doble_vidre') == "0" ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <input type="file" name="imatge">
                <div>
                    <button type="submit" onclick=""
                        class="w-full bg-black hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition-colors duration-200">
                        Desar
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>


@endsection