@extends('pistes.layout')

@section('content')

<h1 class="titol">Llista de pistes</h1>

<a href="{{ route('pistes.create') }}" class="btn-afegir">Afegir pista</a>


<br><br>

<ul class="llista-pistes">
    @foreach($pistes as $pista)
    <li class="pista-targeta">

        <div class="pista-contingut">

            <!-- ESQUERRA -->
            <div class="pista-info">
                <h2 class="pista-nom">{{ $pista->nom }}</h2>

                <p class="pista-descripcio">
                    {{ $pista->descripcio ?? 'Aquesta pista encara no té descripció.' }}
                </p>

                <p><strong>Activa:</strong>
                    <span class="{{ $pista->activa ? 'activa' : 'inactiva' }}">
                        {{ $pista->activa ? 'Sí' : 'No' }}
                    </span>
                </p>

                <p><strong>Doble vidre:</strong>
                    <span class="{{ $pista->doble_vidre ? 'activa' : 'inactiva' }}">
                        {{ $pista->doble_vidre ? 'Sí' : 'No' }}
                    </span>
                </p>

                <div class="accions">
                    <a href="{{ route('pistes.edit', $pista->id) }}" class="btn-editar">Editar</a>

                    <br>
                    <br>

                    <form action="{{ route('pistes.destroy', $pista->id) }}" method="POST" class="formulari-eliminar">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-eliminar">Eliminar</button>
                    </form>
                </div>
            </div>

            <!-- --------------------------------------------------------------------------------- -->

            <!-- DRETA -->
            <div class="pista-imatge">
                <img src="{{ $pista->imatge ?? 'https://via.placeholder.com/250x180' }}" alt="Imatge de la pista">
            </div>

            <!-- --------------------------------------------------------------------------------- -->


        </div>

    </li>
    @endforeach
</ul>

<style>
    
    body {
    background-color: rgb(10, 10, 10);       
    }

    .titol {
        text-align: center;
        font-size: 2.2rem;
        margin-bottom: 20px;
        color: black;
    }

    .btn-afegir {
        display: inline-block;
        padding: 10px 18px;
        background-color: #27ae60;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
    }

    .btn-afegir:hover {
        background-color: #1e8449;
    }

    .llista-pistes {
        list-style: none;
        padding: 0;
        max-width: 1000px;
        margin: 0 auto;
    }

    .pista-targeta {
    background: radial-gradient(circle at center, rgb(32, 32, 32), rgb(20, 20, 20));
    width: 800px;
    height: 300px;
    border-radius: 20px;
    border: 2px solid #727171; /* borde blanco fijo */
    box-shadow: 15px 15px 30px rgb(25, 25, 25),
                -15px -15px 30px rgb(60, 60, 60);
}

    .pista-targeta:hover {
        transform: scale(1.02);
    }

    .pista-contingut {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .pista-info {
        width: 65%;
    }

    .pista-nom {
        font-size: 2rem;
        margin-bottom: 10px;
        color: #2c3e50;
    }

    .pista-descripcio {
        font-size: 1rem;
        margin-bottom: 15px;
        color: #555;
    }

    .pista-imatge {
        width: 30%;
        text-align: right;
    }

    .pista-imatge img {
        width: 100%;
        max-width: 250px;
        border-radius: 10px;
        object-fit: cover;
    }

    .activa {
        color: green;
        font-weight: bold;
    }

    .inactiva {
        color: red;
        font-weight: bold;
    }

    .accions {
        margin-top: 15px;
    }

    .accions a,
    .accions button {
        padding: 8px 14px;
        border-radius: 6px;
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