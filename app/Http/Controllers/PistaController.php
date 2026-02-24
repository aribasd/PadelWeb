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
        $pistes = Pista::all();
        return view('pistes.index', compact('pistes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pistes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'activa' => 'required|boolean',
            'doble_vidre' => 'required|boolean',
        ]);

        Pista::create($request->only([
            'nom',
            'activa',
            'doble_vidre',
        ]));

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
        ]);

        $pista = Pista::findOrFail($id);
        $pista->update($request->only([
            'nom',
            'activa',
            'doble_vidre',
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