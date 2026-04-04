<?php

namespace App\Http\Controllers;


use App\Models\Comunitat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComunitatController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comunitats = Comunitat::orderBy('nom')->get();

        return view('comunitats.index', [
            'comunitats' => $comunitats,
            'subheaderTitol' => 'Comunitats',
            'esLlistaMeves' => false,
        ]);
    }

    /**
     * Comunitats on l'usuari autenticat és membre (taula pivot comunitat_user).
     */
    public function meves()
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 403);

        $comunitats = $user->comunitats()->orderBy('nom')->get();

        return view('comunitats.index', [
            'comunitats' => $comunitats,
            'subheaderTitol' => 'Les meves comunitats',
            'esLlistaMeves' => true,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('comunitats.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'descripcio' => 'required|string|max:255',
            'imatge' => 'required|image|max:5120',
            'rol' => 'required|in:admin,moderador,usuari',
        ]);

        $validated['imatge'] = $request->file('imatge')->store('comunitats', 'public');

        $validated['membres'] = $validated['membres'] ?? '0';

        $comunitat = Comunitat::create($validated);

        if ($user = $request->user()) {
            $comunitat->users()->syncWithoutDetaching([
                $user->id => ['rol' => $validated['rol']],
            ]);
        }

        return redirect()->route('comunitats.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $comunitat = Comunitat::findOrFail($id);
        return view('comunitats.edit', compact('comunitat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $comunitat = Comunitat::findOrFail($id);
        $comunitat->update($request->only([
            'nom',
        ]));

        return redirect()->route('comunitats.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comunitat = Comunitat::findOrFail($id);
        $comunitat->delete();

        return redirect()->route('comunitats.index');
    }
}
