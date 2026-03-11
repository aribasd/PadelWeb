<!DOCTYPE html>
<html lang="ca">
<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Web</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>


    <!-- Linkejem css de app.css *-->
    @vite('resources/css/app.css') 


    <!-- Lato Lletra -->

    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">

</head> 
<body>
<nav class="bg-blue-700 text-white">
  <div class="max-w-7xl mx-auto flex items-center px-2 py-3">

      <h1 class="font-bold text-lg">Padel<span class="text-yellow-500">App</span></h1>

      <div class="flex items-center gap-8 ml-20">
          <a class="hover:text-blue-200 transition" href="{{ route('pistes.index') }}">Pistes</a>
          <a class="hover:text-blue-200 transition" href="{{ route('reserves.index') }}">Reserves</a>
          <a class="hover:text-blue-200 transition" href="{{ route('partits.index') }}">Partits</a>
          <a class="hover:text-blue-200 transition" href="{{ route('partits.index') }}">Galeria</a>
      </div>

      <div class=" flex gap-5 ml-auto mr-0">
          <a href="{{ route('perfils.index') }}" class="flex items-center gap-2 hover:text-blue-200 transition ml-auto">Missatges<!-- @svg('eva-message-circle-outline', ['class' => 'w-6 h-6 text-white']) --></a>
          <a class="hover:text-blue-200 transition" href="{{ route('perfils.index') }}"><x-css-profile /></a>
      </div>

  </div>
</nav>
    <div>
        @yield('content')
    </div>
</body> 
</html>