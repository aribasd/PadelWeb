<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;

use App\Models\Pista;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\PerfilEstadistica;
use App\Services\NivellService;
use App\Models\User;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $hores = range(9, 21);
        $user = Auth::user();

        // Comunitats de l'usuari (per filtrar pistes)
        $comunitatsUsuari = collect();
        if ($user instanceof User) {
            $comunitatsUsuari = $user->comunitats()->orderBy('nom')->get(['comunitats.id', 'comunitats.nom']);
        }

        $comunitatSeleccionadaId = $request->query('comunitat_id');
        $comunitatSeleccionadaId = $comunitatSeleccionadaId !== null ? (int) $comunitatSeleccionadaId : null;

        $teAcces = false;
        if ($user instanceof User && $comunitatSeleccionadaId) {
            $teAcces = $comunitatsUsuari->pluck('id')->contains($comunitatSeleccionadaId);
        }

        // Si no hi ha comunitat seleccionada o no hi té accés, no mostrem pistes reservables
        $pistes = collect();
        if ($teAcces) {
            $pistes = Pista::query()
                ->where('comunitat_id', $comunitatSeleccionadaId)
                ->orderBy('nom')
                ->get();
        }

        $dataClima = Cache::remember('clima_barcelona_v2', 1800, function () {
            try {
                $resp = Http::connectTimeout(1)
                    ->timeout(2)
                    ->get('https://api.openweathermap.org/data/2.5/weather', [
                        'lat' => 41.38,
                        'lon' => 2.17,
                        'appid' => config('services.openweather.key'),
                        'units' => 'metric',
                        'lang' => 'es',
                    ]);

                if ($resp->successful()) {
                    return $resp->json();
                }

                Log::warning('OpenWeather error', [
                    'status' => $resp->status(),
                    'body' => $resp->json(),
                ]);

                return ['_unavailable' => true];
            } catch (\Throwable $e) {
                Log::warning('OpenWeather exception', [
                    'message' => $e->getMessage(),
                ]);

                return ['_unavailable' => true];
            }
        });

        $temp = data_get($dataClima, 'main.temp');
        $descripcion = data_get($dataClima, 'weather.0.description');

        $dataSeleccionada = $request->query('data');
        try {
            $dia = $dataSeleccionada ? Carbon::parse($dataSeleccionada)->startOfDay() : now()->startOfDay();
        } catch (\Throwable $e) {
            $dia = now()->startOfDay();
        }

        $diaIso = $dia->format('Y-m-d');
        $diaText = $dia->translatedFormat('l d F Y');

        $hasOwner = Schema::hasColumn('reserves', 'user_id');
        $select = ['id', 'pista_id', 'hora_inici'];
        if ($hasOwner) {
            $select[] = 'user_id';
        }

        $reserves = Reserva::query()
            ->where('data', $diaIso)
            ->get($select);

        $ocupat = [];
        foreach ($reserves as $r) {
            $hora = substr((string) $r->hora_inici, 0, 2);
            if ($hora === '') continue;

            $ocupat[(int) $r->pista_id][(int) $hora] = [
                'id' => (int) $r->id,
                'user_id' => $hasOwner ? (int) ($r->user_id ?? 0) : null,
            ];
        }

        return view('reserves.index', compact(
            'hores',
            'pistes',
            'dia',
            'diaIso',
            'diaText',
            'temp',
            'descripcion',
            'ocupat',
            'hasOwner',
            'comunitatsUsuari',
            'comunitatSeleccionadaId',
            'teAcces'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    $pista = Pista::findOrFail($request->pista_id);

    $data = $request->data;
    $inici = Carbon::parse($data.' '.$request->hora);
    $hora_inici = $inici->format('H:i');
    $hora_fi = $inici->copy()->addHour()->format('H:i');
    
    // Preu base
    $preu = 7;
    if ($pista->doble_vidre) {
        $preu += 1; // sumar 1 si té doble vidre
    }

     return view('reserves.create', compact('pista', 'hora_inici', 'hora_fi', 'data', 'preu'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'pista_id' => 'required|exists:pistes,id',
            'data' => 'required|date',
            'hora_inici' => 'required|date_format:H:i',
            'hora_fi' => 'required|date_format:H:i|after:hora_inici',
            'preu' => 'required|integer|min:0',
        ]);

        if (! $request->user()) {
            abort(403);
        }

        $data = $request->only([
            'pista_id',
            'data',
            'hora_inici',
            'hora_fi',
            'preu',
        ]);

        // Si existeix user_id a la taula, guardem el propietari
        if (Schema::hasColumn('reserves', 'user_id')) {
            $data['user_id'] = (int) $request->user()->id;
        }

        $reserva = Reserva::create($data);

        // XP per reserva
        $user = Auth::user();
        if ($user) {
            app(NivellService::class)->awardXp($user, 25);
        }

        // Insígnia "10 reserves" (sobre l'esquema existent: Insignia -> PerfilEstadistica)
        if ($user) {
            $totalReserves = Reserva::query()->count();

            // TODO: idealment comptar per usuari quan la reserva estigui vinculada a usuari.
            // De moment, mentre no hi hagi user_id a reserves, fem el check global per poder avançar la feature.
            if ($totalReserves >= 10) {
                $perfil = $user->perfil_estadistiques;
                if ($perfil instanceof PerfilEstadistica) {
                    $jaLaTe = $perfil->insignies()
                        ->where('nom', '10 reserves')
                        ->exists();

                    if (! $jaLaTe) {
                        $perfil->insignies()->create([
                            'nom' => '10 reserves',
                            'dificultat' => 'baixa',
                        ]);
                    }
                }
            }
        }

        return redirect()->route('reserves.index', ['data' => $request->data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reserva = Reserva::findOrFail($id);

        // Només el propietari pot editar (si existeix user_id a DB)
        if (Schema::hasColumn('reserves', 'user_id')) {
            abort_unless((int) $reserva->user_id === (int) Auth::id(), 403);
        }

        $hores = range(9, 21);
        $comunitatId = Pista::query()->whereKey($reserva->pista_id)->value('comunitat_id');

        return view('reserves.edit', [
            'reserva' => $reserva,
            'hores' => $hores,
            'comunitatId' => $comunitatId,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'data' => 'required|date',
            'hora_inici' => 'required|date_format:H:i',
            'hora_fi' => 'required|date_format:H:i|after:hora_inici',
        ]);

        $reserva = Reserva::findOrFail($id);

        // Només el propietari pot editar (si existeix user_id a DB)
        if (Schema::hasColumn('reserves', 'user_id')) {
            abort_unless((int) $reserva->user_id === (int) Auth::id(), 403);
        }

        // Evitar solapament: mateixa pista + mateix dia + mateixa hora
        $conflict = Reserva::query()
            ->where('id', '!=', $reserva->id)
            ->where('pista_id', $reserva->pista_id)
            ->where('data', $request->input('data'))
            ->where('hora_inici', $request->input('hora_inici'))
            ->exists();
        if ($conflict) {
            return back()
                ->withErrors(['hora_inici' => 'Aquesta franja ja està ocupada.'])
                ->withInput();
        }

        $reserva->update($request->only([
            'data',
            'hora_inici',
            'hora_fi',
        ]));

        $comunitatId = Pista::query()->whereKey($reserva->pista_id)->value('comunitat_id');
        return redirect()->route('reserves.index', [
            'data' => $reserva->data,
            'comunitat_id' => $comunitatId,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reserva = Reserva::findOrFail($id);

        // Si la reserva té propietari, només el propietari la pot eliminar
        if (Schema::hasColumn('reserves', 'user_id')) {
            abort_unless((int) $reserva->user_id === (int) Auth::id(), 403);
        }

        $reserva->delete();

        return redirect()->route('reserves.index', [
            'data' => $reserva->data,
            'comunitat_id' => request('comunitat_id'),
        ]);
    }
}
