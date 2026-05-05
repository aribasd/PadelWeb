<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partit;
use App\Models\Reserva;
class PartitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partits = Partit::all();

        $reserves = Reserva::query()
            ->with(['pistes', 'partits'])
            ->get();

        return view('partits.index', compact('partits', 'reserves'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $reservaId = $request->query('reserva_id');
        $reserva = $reservaId ? Reserva::query()->with('pistes')->findOrFail((int) $reservaId) : null;

        return view('partits.create', compact('reserva'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reserva_id' => 'required|exists:reserves,id',
            'nom1' => 'nullable|string|max:255',
            'nom2' => 'nullable|string|max:255',
            'nom3' => 'nullable|string|max:255',
            'nom4' => 'nullable|string|max:255',
        ]);

        $partit = Partit::query()->create([
            'reserva_id' => (int) $validated['reserva_id'],
            'nom1' => $validated['nom1'] ?? null,
            'nom2' => $validated['nom2'] ?? null,
            'nom3' => $validated['nom3'] ?? null,
            'nom4' => $validated['nom4'] ?? null,
            // per defecte: encara no s'ha marcat cap resultat
            'set1' => false,
            'set2' => false,
            'set3' => false,
        ]);

        return redirect()->route('partits.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $partit = Partit::findOrFail($id);
        return view('partits.edit', compact('partit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom1' => 'nullable|string|max:255',
            'nom2' => 'nullable|string|max:255',
            'nom3' => 'nullable|string|max:255',
            'nom4' => 'nullable|string|max:255',
            'set1' => 'required|boolean',
            'set2' => 'required|boolean',
            'set3' => 'required|boolean',
        ]);

        $partit = Partit::findOrFail($id);
        $partit->update($request->only([
            'nom1', 'nom2', 'nom3', 'nom4', 'set1', 'set2', 'set3'
        ]));

        return redirect()->route('partits.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $partit = Partit::findOrFail($id);
        $partit->delete();

        return redirect()->route('partits.index');
    }
}