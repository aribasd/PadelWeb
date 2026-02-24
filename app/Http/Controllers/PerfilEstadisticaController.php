<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerfilEstadistica;

class PerfilEstadisticaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perfil_estadistiques = PerfilEstadistica::all();
        return view('perfil_estadistiques.index', compact('perfil_estadistiques'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('perfil_estadistiques.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'partits_jugats' => 'required|integer|min:0',
            'win_rate' => 'required|numeric|min:0|max:100',
            'nivell' => 'required|integer|min:1|max:10',
            'data_naixament' => 'required|date',
            'foto_perfil' => 'nullable|string',
        ]);

        PerfilEstadistica::create($request->only([
            'partits_jugats',
            'win_rate',
            'nivell',
            'data_naixament',
            'foto_perfil',
        ]));

        return redirect()->route('perfil_estadistiques.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $perfil_estadistiques = PerfilEstadistica::findOrFail($id);
        return view('perfil_estadistiques.edit', compact('perfil_estadistiques'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'partits_jugats' => 'required|integer|min:0',
            'win_rate' => 'required|numeric|min:0|max:100',
            'nivell' => 'required|integer|min:1|max:10',
            'data_naixament' => 'required|date',
            'foto_perfil' => 'nullable|string',
        ]);

        $perfil_estadistiques = PerfilEstadistica::findOrFail($id);

        $perfil_estadistiques->update($request->only([
            'partits_jugats',
            'win_rate',
            'nivell',
            'data_naixament',
            'foto_perfil',
        ]));

        return redirect()->route('perfil_estadistiques.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $perfil_estadistiques = PerfilEstadistica::findOrFail($id);
        $perfil_estadistiques->delete();

        return redirect()->route('perfil_estadistiques.index');
    }
}