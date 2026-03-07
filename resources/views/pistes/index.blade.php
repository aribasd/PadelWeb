@extends('pistes.layout')


@section('content')

<link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <h1 class="titol">Llista de pistes</h1>

<div class="afegirPista">
<a href="{{ route('pistes.create') }}" class="btn-afegir">Afegir pista</a>
</div>

<br><br>

<ul class="llista-pistes">
    @foreach($pistes as $pista)

    <li class="pista-targeta">

        <div class="pista-contingut">

            <!-- ESQUERRA -->

            <div class="pista-info flex flex-col gap-4 ml-2">
                <h2 class="pista-nom">{{ $pista->nom }}</h2>


                <p class="pista-descripcio">
                    {{ $pista->descripcio ?? 'Aquesta pista encara no té descripció.' }}
                </p>

                <div class="doble">

                <p>Doble vidre:
                    <span class="{{ $pista->doble_vidre ? 'activa' : 'inactiva' }}">
                        {{ $pista->doble_vidre ? 'Sí' : 'No' }}
                    </span>
                </p>

                </div>

                <div class="accions flex items-center gap-2">

                    <div>
                        <a href="{{ route('pistes.edit', $pista->id) }}"  class="btn-editar ml-2">Editar</a>
                    </div>

                    <form action="{{ route('pistes.destroy', $pista->id) }}" method="POST" class="formulari-eliminar">
                        @csrf
                   
                        @method('DELETE')

                  
                    <button
                        class="group relative flex h-15 w-12 flex-col items-center ml-2 justify-center overflow-hidden rounded-xl border-2 border-red-800 bg-red-400 hover:bg-red-600"
                        >
                        <!-- Paper Basura  -->
                        <svg
                            viewBox="0 0 1.625 1.625"
                            class="absolute -top-7 fill-white delay-100 group-hover:top-6 group-hover:animate-[spin_1.4s] group-hover:duration-1000"
                            height="5"
                            width="10"
                        >
                            <path
                            d="M.471 1.024v-.52a.1.1 0 0 0-.098.098v.618c0 .054.044.098.098.098h.487a.1.1 0 0 0 .098-.099h-.39c-.107 0-.195 0-.195-.195"
                            ></path>
                            <path
                            d="M1.219.601h-.163A.1.1 0 0 1 .959.504V.341A.033.033 0 0 0 .926.309h-.26a.1.1 0 0 0-.098.098v.618c0 .054.044.098.098.098h.487a.1.1 0 0 0 .098-.099v-.39a.033.033 0 0 0-.032-.033"
                            ></path>
                            <path
                            d="m1.245.465-.15-.15a.02.02 0 0 0-.016-.006.023.023 0 0 0-.023.022v.108c0 .036.029.065.065.065h.107a.023.023 0 0 0 .023-.023.02.02 0 0 0-.007-.016"
                            ></path>
                        </svg>
                        <!-- Tapa Basura -->
                        <svg
                            width="15"
                            fill="none"
                            viewBox="0 0 39 7"
                            class="origin-right duration-500 group-hover:rotate-90"
                        >
                            <line stroke-width="4" stroke="white" y2="5" x2="39" y1="5"></line>
                            <line
                            stroke-width="3"
                            stroke="white"
                            y2="1.5"
                            x2="26.0357"
                            y1="1.5"
                            x1="12"
                            ></line>
                        </svg>

                        <!-- Basura Cubell  -->
                        <svg width="15" fill="none" viewBox="0 0 33 39" class="">
                            <mask fill="white" id="path-1-inside-1_8_19">
                            <path
                                d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z"
                            ></path>
                            </mask>
                            <path
                            mask="url(#path-1-inside-1_8_19)"
                            fill="white"
                            d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z"
                            ></path>
                            <path stroke-width="4" stroke="white" d="M12 6L12 29"></path>
                            <path stroke-width="4" stroke="white" d="M21 6V29"></path>
                    </svg>
                    </button>
                    <!-- ----------------------------------------------------------------- -->
             
                    </form>
                </div>
            </div>

            <!-- --------------------------------------------------------------------------------- -->

                <img src="{{ $pista->imatge ?? 'https://via.placeholder.com/250x180' }}" alt="Imatge de la pista">

            <!-- --------------------------------------------------------------------------------- -->


        </div>

    </li>
    @endforeach
</ul>

<style>


    .afegirPista {
  position: relative;
  display: flex;
  align-items: center;
  gap: 4px;
  padding: 16px 36px;
  border: 4px solid;
  border-color: transparent;
  font-size: 16px;
  background-color: inherit;
  border-radius: 100px;
  font-weight: 600;
  color: greenyellow;
  box-shadow: 0 0 0 2px greenyellow;
  cursor: pointer;
  overflow: hidden;
  transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
}

.afegirPista svg {
  position: absolute;
  width: 24px;
  fill: greenyellow;
  z-index: 9;
  transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1);
}

.afegirPista .arr-1 {
  right: 16px;
}

.afegirPista .arr-2 {
  left: -25%;
}

.afegirPista .circle {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 20px;
  height: 20px;
  background-color: greenyellow;
  border-radius: 50%;
  opacity: 0;
  transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1);
}

.afegirPista .text {
  position: relative;
  z-index: 1;
  transform: translateX(-12px);
  transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1);
}

.afegirPista:hover {
  box-shadow: 0 0 0 12px transparent;
  color: #212121;
  border-radius: 12px;
}

.afegirPista:hover .arr-1 {
  right: -25%;
}

.afegirPista:hover .arr-2 {
  left: 16px;
}

.afegirPista:hover .text {
  transform: translateX(12px);
}

.afegirPista:hover svg {
  fill: #212121;
}

.afegirPista:active {
  scale: 0.95;
  box-shadow: 0 0 0 4px greenyellow;
}

.afegirPista:hover .circle {
  width: 220px;
  height: 220px;
  opacity: 1;
}

    .titol {
    color: white;
    text-align: center;
    font-size: 58px;
    font-weight: 900;
    }
    
    body {
    background-color:  rgb(35, 35, 35); 
          
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
    background: rgb(65, 65, 65);
    width: 1000px;
    height: 320px;
    border-radius: 30px;
    margin: 0 auto; /* CENTRA horizontalmente */
    }
    
    .pista-targeta:hover {
        transform: scale(1.02);
    }

    .pista-contingut {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .doble {

    color: black;
    font-weight: 700px;
    }



    .pista-nom {
        font-size: 50px;
        margin-bottom: 10px;
        color:  rgb(230, 241, 88);
        font-weight: 700;
    }

    .pista-descripcio {
        font-size: 1rem;
        margin-bottom: 15px;
        color: rgb(221, 225, 163);
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


    .Btn {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  width: 100px;
  height: 40px;
  border: none;
  padding: 0px 20px;
  background-color: black;
  color: white;
  font-weight: 700;
  cursor: pointer;
  border-radius: 10px;
  box-shadow: 5px 5px 0px black;
  transition-duration: 0.3s;
}

.svg {
  width: 13px;
  position: absolute;
  right: 0;
  margin-right: 20px;
  fill: white;
  transition-duration: 0.3s;
}


</style>

@endsection