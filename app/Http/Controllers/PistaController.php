<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pista;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PistaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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

    
        $pistes = Pista::query()->orderBy('nom')->get();
        // A la pàgina de pistes mostrem totes al showcase (gestió); a inici només les actives.
        $projectShowcaseItems = $pistes->map->toProjectShowcaseItem()->values()->all();

        return view('pistes.index', compact('pistes', 'projectShowcaseItems', 'temp', 'descripcion'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $pista = $request->query('pista'); 
        $hora  = $request->query('hora');
        $data  = $request->query('data');

        
        return view('pistes.create', compact('pista', 'hora' , 'data'));    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'doble_vidre' => 'required|boolean',
            'imatge' => 'nullable|image',
        ]);

        $validated['activa'] = true; // per defecte activa

        if($request->hasFile('imatge')) {
            $validated['imatge'] = $request->file('imatge')->store('pistes', 'public');
        }

        Pista::create($validated);

        return redirect()->route('pistes.index');
    }

    /**
     * Show the specified resource.
     */
    public function show(string $id)
    {
        $pista = Pista::findOrFail($id);
        return view('pistes.show', compact('pista'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pista = Pista::findOrFail($id);
        return view('pistes.edit', compact('pista'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'activa' => 'required|boolean',
            'doble_vidre' => 'required|boolean',
            'imatge' => 'nullable|image',
        ]);

        $pista = Pista::findOrFail($id);

        if ($request->hasFile('imatge')) {
            $validated['imatge'] = $request->file('imatge')->store('pistes', 'public');
        } else {
            unset($validated['imatge']);
        }

        $pista->update($validated);

        return redirect()->route('pistes.index');
    }
        
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pista = Pista::findOrFail($id);
        $pista->delete();

        return redirect()->route('pistes.index');
    }
    
}