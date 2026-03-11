@extends('layouts.layout')

@section('content')

<div class="flex flex-col min-h-screen">

      <div class="flex items-center h-20 bg-gray-700">    
        <h1 class="text-white text-2xl font-bold ml-10">Pistes</h1>
    </div>


  <div class="bg-white flex-1 p-5">


    <div class="mt-5 ml-10">
        <a href="{{ route('pistes.create') }}" class="btn-afegir"><button
                title="Add New"
                class="flex group cursor-pointer outline-none hover:rotate-90 duration-300">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="50px"
                    height="50px"
                    viewBox="0 0 24 24"
                    class="stroke-zinc-400 fill-none group-hover:fill-zinc-800 group-active:stroke-zinc-200 group-active:fill-zinc-600 group-active:duration-0 duration-300">
                    <path
                        d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z"
                        stroke-width="1.5"></path>
                    <path d="M8 12H16" stroke-width="1.5"></path>
                    <path d="M12 16V8" stroke-width="1.5"></path>
                </svg>
            </button></a>
    </div>

</div>

</div>

@endsection