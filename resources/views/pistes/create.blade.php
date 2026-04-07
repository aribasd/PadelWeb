@extends('layouts.layout')

@section('content')

    <div class="flex min-h-screen flex-col">

        @include('components.propis.subheader', ['titol' => 'Nova Pista'])

        <div class="mt-8 flex-1 p-5">

            <div class="mx-auto max-w-lg rounded-xl border border-slate-200 bg-gray-100 p-8 shadow-lg">

                <form action="{{ route('pistes.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                    @csrf

                    <div class="flex flex-col">
                        <label for="nom" class="mb-2 font-semibold text-gray-500">Nom de la pista</label>
                        <input type="text" id="nom" name="nom" placeholder="Nom de la Pista" value="{{ old('nom') }}"
                            required
                            class="rounded-md border border-slate-200 bg-white p-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div class="flex flex-col">
                        <label for="doble_vidre" class="mb-2 font-semibold text-gray-500">Doble Vidre</label>
                        <select id="doble_vidre" name="doble_vidre" required
                            class="rounded-md border border-slate-200 bg-white p-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="1" {{ old('doble_vidre') == '1' ? 'selected' : '' }}>Sí</option>
                            <option value="0" {{ old('doble_vidre') == '0' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <span class="mb-2 font-semibold text-gray-500" id="imatge-label">Imatge de la pista (opcional)</span>
                        <input type="file" id="imatge" name="imatge" accept="image/*" class="sr-only"
                            aria-labelledby="imatge-label">

                        <div id="drop-zone" tabindex="0" role="button" aria-labelledby="imatge-label"
                            class="group relative flex min-h-[240px] w-full cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-white/80 px-4 py-8 text-center transition hover:border-blue-400 hover:bg-blue-50/50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <div id="drop-placeholder" class="flex flex-col items-center gap-2 text-slate-500">
                                <svg class="h-12 w-12 text-slate-400 transition group-hover:text-blue-500"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3A1.5 1.5 0 0 0 1.5 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                                <span class="text-sm font-medium text-slate-600">Arrossega una imatge aquí</span>
                                <span class="text-xs text-slate-400">o fes clic per triar un fitxer</span>
                            </div>
                            <img id="imatge-preview" src="" alt=""
                                class="hidden max-h-52 w-full rounded-lg object-contain shadow-sm">
                            <p id="imatge-nom" class="mt-2 hidden max-w-full truncate text-xs text-slate-600"></p>
                        </div>
                        @error('imatge')
                            <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                        <a href="{{ route('pistes.index') }}"
                            class="rounded-lg border border-slate-500 bg-slate-100 px-4 py-2 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-200">
                            Cancel·lar
                        </a>
                        <button type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Crear Pista
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('imatge');
            const dropZone = document.getElementById('drop-zone');
            const placeholder = document.getElementById('drop-placeholder');
            const preview = document.getElementById('imatge-preview');
            const nomEl = document.getElementById('imatge-nom');
            if (!fileInput || !dropZone) return;

            let previewUrl = null;

            function setFile(file) {
                if (!file || !file.type.startsWith('image/')) return;
                const dt = new DataTransfer();
                dt.items.add(file);
                fileInput.files = dt.files;
                if (previewUrl) URL.revokeObjectURL(previewUrl);
                previewUrl = URL.createObjectURL(file);
                preview.src = previewUrl;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                nomEl.textContent = file.name;
                nomEl.classList.remove('hidden');
            }

            dropZone.addEventListener('click', function () {
                fileInput.click();
            });

            dropZone.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    fileInput.click();
                }
            });

            fileInput.addEventListener('change', function () {
                const file = this.files && this.files[0];
                if (file) setFile(file);
            });

            ['dragenter', 'dragover'].forEach(function (ev) {
                dropZone.addEventListener(ev, function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.classList.add('border-blue-500', 'bg-blue-50');
                });
            });

            dropZone.addEventListener('dragleave', function (e) {
                e.preventDefault();
                dropZone.classList.remove('border-blue-500', 'bg-blue-50');
            });

            dropZone.addEventListener('drop', function (e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.remove('border-blue-500', 'bg-blue-50');
                const file = e.dataTransfer.files && e.dataTransfer.files[0];
                if (file) setFile(file);
            });
        });
    </script>
@endpush
