<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Partit;
use App\Models\Reserva;
class PartitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reserves = Reserva::query()
            ->with(['pistes', 'partits', 'users'])
            ->orderByDesc('data')
            ->orderByDesc('hora_inici')
            ->paginate(20)
            ->withQueryString();

        return view('partits.index', compact('reserves'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $reservaId = $request->query('reserva_id');
        $reserva = $reservaId
            ? Reserva::query()->with(['pistes', 'users'])->findOrFail((int) $reservaId)
            : null;

        // Llista d'amics acceptats per omplir els suggeriments dels camps
        // de jugadors. Es manté com a "datalist" perquè l'usuari pugui triar
        // un amic o, si vol, escriure un nom a mà.
        $amics = collect();
        $user = Auth::user();
        if ($user instanceof \App\Models\User) {
            $amics = $user->amicsAcceptats()->sortBy('name')->values();
        }

        return view('partits.create', compact('reserva', 'amics'));
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
        $partit = Partit::with('reserves')->findOrFail($id);

        // Només el propietari de la reserva pot eliminar el partit (si tenim user_id)
        if (Schema::hasColumn('reserves', 'user_id')) {
            $ownerId = (int) ($partit->reserves->user_id ?? 0);
            abort_unless($ownerId === (int) Auth::id(), 403);
        }

        $partit->delete();

        return redirect()->route('partits.index');
    }
}