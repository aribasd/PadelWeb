<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Pel-lícules</title>
    <link rel="stylesheet" href="{{ asset('css/layoutestil.css') }}">



</head>
<body>
    <nav>    
        <a href= "{{ route('pistes.index') }}">Pistes</a>
    </nav>

    <div>
        @yield('content')
    </div>
</body>
</html>