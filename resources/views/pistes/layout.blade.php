<!DOCTYPE html>
<html lang="ca">
<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Web</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite('resources/css/app.css')


    <!-- Lato Lletra -->

    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">


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