<!DOCTYPE html>
<html>

<head>
  <style>
    body {
      background-color: rgb(49, 49, 49);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin-right: 0;
    }
  </style>

  <script src="https://cdn.tailwindcss.com"></script>

  <link href="https://cdn.jsdelivr.net/npm/daisyui@4/dist/full.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

  <div class="hero min-h-screen"
    style="background-image: url(https://images.unsplash.com/photo-1646649853703-7645147474ba?fm=jpg&q=60&w=3000&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8cGlzdGElMjBkZSUyMHAlQzMlQTFkZWx8ZW58MHx8MHx8fDA%3D);">
    <div class="hero-overlay"></div>
    <div class="hero-content text-neutral-content text-center">
      <div class="max-w-md">
        <h1 class="mb-5 text-5xl font-bold">SocialPadel</h1>
        <p class="mb-5">
          Reserva pistes, comparteix amb amics i segueix el teu progrés en la teva comunitat de pàdel.
        </p>
        <a href="{{ route('login') }}"
          class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
          Inicia sessió
        </a>

        <a href="{{ route('register') }}"
          class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
          Registra’t
        </a>
      </div>
    </div>
  </div>

</body>

</html>