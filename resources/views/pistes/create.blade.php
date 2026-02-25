@extends('pistes.layout') 

@section('content')

<h1>Afegir nova Pista</h1>

<form action="{{ route('pistes.store') }}" method="POST">
    @csrf

    <div style="margin-bottom: 10px;">
        <label for="nom">Nom de la pista</label>
        <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required>
    </div>

    <div style="margin-bottom: 10px;">
        <label for="activa">Activa</label>
        <select id="activa" name="activa" required>
            <option value="1" {{ old('activa') == "1" ? 'selected' : '' }}>Sí</option>
            <option value="0" {{ old('activa') == "0" ? 'selected' : '' }}>No</option>
        </select>
    </div>

    <div style="margin-bottom: 10px;">
        <label for="doble_vidre">Doble Vidre</label>
        <select id="doble_vidre" name="doble_vidre" required>
            <option value="1" {{ old('doble_vidre') == "1" ? 'selected' : '' }}>Sí</option>
            <option value="0" {{ old('doble_vidre') == "0" ? 'selected' : '' }}>No</option>
        </select>
    </div>

    <button type="submit" style="padding: 8px 15px; background-color:#3498db; color:white; border:none; border-radius:5px; cursor:pointer;">
        Desar
    </button>
</form>

@endsection