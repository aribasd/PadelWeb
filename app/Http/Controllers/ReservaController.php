<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;

use App\Models\Pista;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $hores = range(9, 21);
        $pistes = Pista::all();

        $dataClima = Cache::get('clima_barcelona_v2');
        if (!$dataClima) {
            try {
                $resp = Http::timeout(8)->get('https://api.openweathermap.org/data/2.5/weather', [
                    'lat' => 41.38,
                    'lon' => 2.17,
                    'appid' => config('services.openweather.key'),
                    'units' => 'metric',
                    'lang' => 'es',
                ]);

                if ($resp->successful()) {
                    $dataClima = $resp->json();
                    Cache::put('clima_barcelona_v2', $dataClima, 1800);
                } else {
                    $dataClima = $resp->json();
                    Log::warning('OpenWeather error', [
                        'status' => $resp->status(),
                        'body' => $dataClima,
                    ]);
                }
            } catch (\Throwable $e) {
                $dataClima = null;
                Log::warning('OpenWeather exception', [
                    'message' => $e->getMessage(),
                ]);
            }
        }

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

        $reserves = Reserva::where('data', $diaIso)->get();

        return view('reserves.index', compact('hores', 'pistes', 'reserves', 'dia', 'diaIso', 'diaText', 'temp', 'descripcion'));
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

        Reserva::create($request->only([
            'pista_id',
            'data',
            'hora_inici',
            'hora_fi',
            'preu',
        ]));

        return redirect()->route('reserves.index', ['data' => $request->data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reserva = Reserva::findOrFail($id);
        return view('reserves.edit', compact('reserva'));
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
            'preu' => 'required|integer|min:0',
        ]);

        $reserva = Reserva::findOrFail($id);
        $reserva->update($request->only([
            'data',
            'hora_inici',
            'hora_fi',
            'preu',
        ]));

        return redirect()->route('reserves.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();

        return redirect()->route('reserves.index');
    }
}
