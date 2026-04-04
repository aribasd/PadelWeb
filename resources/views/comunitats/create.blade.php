@extends('layouts.layout')

@section('content')

    <div class="flex min-h-screen flex-col">
        @include('components.propis.subheader', ['titol' => 'Nova comunitat'])

        <div class="flex-1 p-5">
            <div class="mx-auto mt-10 max-w-lg rounded-xl bg-gray-100 p-6 shadow-lg">
                <form action="{{ route('comunitats.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <input type="hidden" name="rol" value="usuari">
                    <input type="hidden" name="membres" value="0">


                    {{--  NOM DE LA COMUNITAT  --}}

                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col">
                            <label for="nom" class="mb-2 font-semibold text-gray-500">Nom de la comunitat</label>
                            <input type="text" id="nom" name="nom" value="{{ old('nom') }}" maxlength="255" minlength="3" required
                                autocomplete="organization"
                                class="rounded-md border border-slate-200 bg-white p-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            @error('nom')
                                <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                            @enderror
                        </div>

                        {{--  DESCRIPCIÓ DE LA COMUNITAT  --}}

                        <div class="flex flex-col">
                            <label for="descripcio" class="mb-2 font-semibold text-gray-500">Descripció de la comunitat</label>
                            <input type="text" id="descripcio" name="descripcio" value="{{ old('descripcio') }}" maxlength="255" required
                                autocomplete="off"
                                class="rounded-md border border-slate-200 bg-white p-2  text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            @error('descripcio')
                                <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                            @enderror
                        </div>

                        {{--  IMATGE DE LA COMUNITAT  --}}

                        <div class="flex flex-col">
                            <span class="mb-2 font-semibold text-gray-500">Imatge de la comunitat</span>
                            <input type="file" id="imatge" name="imatge" accept="image/*" required class="sr-only">

                            <div
                                id="drop-zone"
                                tabindex="0"
                                role="button"
                                aria-controls="imatge"
                                class="group relative flex min-h-[240px] w-full cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-white/80 px-4 py-8 text-center transition hover:border-blue-400 hover:bg-blue-50/50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            >
                                <div id="drop-placeholder" class="flex flex-col items-center gap-2 text-slate-500">
                                    <svg class="h-12 w-12 text-slate-400 transition group-hover:text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3A1.5 1.5 0 0 0 1.5 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                    <span class="text-sm font-medium text-slate-600">Arrossega una imatge aquí</span>
                                    <span class="text-xs text-slate-400">o fes clic per triar un fitxer</span>
                                </div>
                                <img id="imatge-preview" src="" alt="" class="hidden max-h-52 w-full rounded-lg object-contain shadow-sm">
                                <p id="imatge-nom" class="mt-2 hidden max-w-full truncate text-xs text-slate-600"></p>
                            </div>
                            @error('imatge')
                                <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                        <a href="{{ route('comunitats.index') }}"
                            class="rounded-lg border border-slate-500 bg-slate-100 px-4 py-2 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-200">
                            Cancel·lar
                        </a>
                        <button type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Crear comunitat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- SCRIPT DRAG AND DROP IMATGE --}}
    <script>
        (function () {
            var input = document.getElementById('imatge');
            var zone = document.getElementById('drop-zone');
            var preview = document.getElementById('imatge-preview');
            var placeholder = document.getElementById('drop-placeholder');
            var nomFitxer = document.getElementById('imatge-nom');

            if (!input || !zone) return;

            function setFile(file) {
                if (!file || !file.type.match(/^image\//)) return;
                var dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                nomFitxer.textContent = file.name;
                nomFitxer.classList.remove('hidden');
                var reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }

            zone.addEventListener('click', function () { input.click(); });
            zone.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); input.click(); }
            });

            function dragOn() {
                zone.classList.add('border-blue-500', 'bg-blue-50');
                zone.classList.remove('border-slate-300', 'bg-white/80');
            }
            function dragOff() {
                zone.classList.remove('border-blue-500', 'bg-blue-50');
                zone.classList.add('border-slate-300', 'bg-white/80');
            }

            ['dragenter', 'dragover'].forEach(function (ev) {
                zone.addEventListener(ev, function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dragOn();
                });
            });
            zone.addEventListener('dragleave', function (e) {
                e.preventDefault();
                e.stopPropagation();
                if (!zone.contains(e.relatedTarget)) dragOff();
            });
            zone.addEventListener('drop', function (e) {
                e.preventDefault();
                e.stopPropagation();
                dragOff();
                var f = e.dataTransfer.files && e.dataTransfer.files[0];
                if (f) setFile(f);
            });

            input.addEventListener('change', function () {
                var f = input.files && input.files[0];
                if (f) setFile(f);
            });
        })();
    </script>

@endsection
