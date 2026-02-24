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
        return view ('perfil_estadistiques.index', compact('perfil_estadistiques'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $perfil_estadistiques = PerfilEstadistica::all();
        return view('perfil_estadistiques.index', compact('perfil_estadistiques'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
