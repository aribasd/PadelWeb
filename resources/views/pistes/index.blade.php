@extends('pistes.layout')

@section('content')

<h1>Llista de Pistes</h1>

   <a href="{{ route('pistes.create') }}" class = "afegirpistes">Afegir Pistes</a>

<br><br>

<ul>
@foreach($pistes as $pista)
    <li class="pista-item">
        <strong class="pista-nom">{{ $pista->nom }}</strong> <br>

        <p><strong>Activa:</strong> <span class="{{ $pista->activa ? 'activo' : 'inactivo' }}">
            {{ $pista->activa ? 'Sí' : 'No' }}
        </span></p>

        <p><strong>Doble Vidre:</strong> <span class="{{ $pista->doble_vidre ? 'activo' : 'inactivo' }}">
            {{ $pista->doble_vidre ? 'Sí' : 'No' }}
        </span></p>

        <div class="acciones">
            <a href="{{ route('pistes.edit', $pista->id) }}" class="btn-editar">Editar</a>

            <form action="{{ route('pistes.destroy', $pista->id) }}" method="POST" class="form-eliminar">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-eliminar">Eliminar</button>
            </form>
        </div>

        <hr>
    </li>
@endforeach
</ul>

<style>
    .titulo {
        font-size: 2rem;
        color: #2c3e50;
        margin-bottom: 1rem;
        text-align: center;
        font-weight: bold;
    }

    .lista-pistes {
        list-style: none;
        padding: 0;
        max-width: 800px;
        margin: 0 auto;
    }

    .pista-item {
        background-color: #f7f7f7;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .pista-nom {
        font-size: 1.5rem;
        color: #34495e;
    }

    .activo {
        color: green;
        font-weight: bold;
    }

    .inactivo {
        color: red;
        font-weight: bold;
    }

    .acciones {
        margin-top: 10px;
    }

    .acciones a,
    .acciones button {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.9rem;
        margin-right: 5px;
        border: none;
        cursor: pointer;
    }

    .btn-editar {
        background-color: #3498db;
        color: white;
    }

    .btn-editar:hover {
        background-color: #2980b9;
    }

    .btn-eliminar {
        background-color: #e74c3c;
        color: white;
    }

    .btn-eliminar:hover {
        background-color: #c0392b;
    }


    </style>


@endsection