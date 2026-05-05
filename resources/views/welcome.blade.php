<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
  <main class="min-h-screen bg-slate-900">
    <div class="mx-auto flex min-h-screen w-full flex-col md:flex-row">
      <section class="order-2 relative flex items-center bg-slate-950/90 px-6 py-12 text-white md:order-2 md:w-1/2 md:px-8 md:py-14 md:flex-1">
        <div class="absolute inset-0 bg-black/20 backdrop-blur-md"></div>
        <div class="relative w-full max-w-lg">
          <p class="text-sm font-semibold tracking-widest text-white/70">SOCIALPADEL</p>
          <h1 class="mt-2 text-5xl font-bold leading-tight">
            Reserva, juga i connecta
          </h1>
          <p class="mt-5 text-base text-white/80 sm:text-lg">
            Reserva pistes, uneix-te a comunitats, parla amb amics i segueix el teu progrés al pàdel.
          </p>

          <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('login') }}"
              class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-black">
              Inicia sessió
            </a>

            <a href="{{ route('register') }}"
              class="inline-flex items-center justify-center rounded-lg border border-white/20 bg-white/10 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-white/15 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-black">
              Registra’t
            </a>
          </div>
        </div>
      </section>

      <section class="order-1 relative min-h-[45vh] overflow-hidden md:order-1 md:min-h-screen md:w-1/2 md:flex-1">
        <img
          src="https://images.unsplash.com/photo-1646649853703-7645147474ba?fm=jpg&q=60&w=3000&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8cGlzdGElMjBkZSUyMHAlQzMlQTFkZWx8ZW58MHx8MHx8fDA%3D"
          alt="Pista de pàdel"
          class="absolute inset-0 h-full w-full object-cover"
        >
        <div class="absolute inset-0 bg-slate-900/35"></div>
      </section>

    </div>
  </main>

</body>

</html>