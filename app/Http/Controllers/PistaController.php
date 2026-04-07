<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pista;

class PistaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pistes = Pista::query()->orderBy('nom')->get();
        // A la pàgina de pistes mostrem totes al showcase (gestió); a inici només les actives.
        $projectShowcaseItems = $pistes->map->toProjectShowcaseItem()->values()->all();

        return view('pistes.index', compact('pistes', 'projectShowcaseItems'));
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
        $request->validate([
            'nom' => 'required|string|max:255',
            'activa' => 'required|boolean',
            'doble_vidre' => 'required|boolean',
            'imatge' => 'nullable|image',
        ]);

        $pista = Pista::findOrFail($id);
        $pista->update($request->only([
            'nom',
            'activa',
            'doble_vidre',
            'imatge',
        ]));

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