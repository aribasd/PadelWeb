<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;

use App\Models\Pista;

use Carbon\Carbon;


class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hores = range(9, 21);
        $pistes = Pista::all();

        $reserves = Reserva::where('data', date('Y-m-d'))->get();

        return view('reserves.index', compact('hores', 'pistes', 'reserves'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    $pista = Pista::findOrFail($request->pista_id);

    $hora_inici  = $request->hora;
    $hora_fi     = date('H:i', strtotime($hora_inici . ' +1 hour'));
    $data        = $request->data;
    
    // Precio base
    $preu = 7;
    if ($pista->doble_vidre) {
        $preu += 1; // sumar 1 si tiene doble vidre
    }

     return view('reserves.create', compact('pista', 'hora_inici', 'hora_fi', 'data', 'preu'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'pista_id' => 'required|string',
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

        return redirect()->route('reserves.index');
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
