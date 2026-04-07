<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comunitat;
use App\Models\Pista;

class IniciController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comunitats = Comunitat::all();
        $projectShowcaseItems = Pista::query()
            ->where('activa', true)
            ->orderBy('nom')
            ->get()
            ->map(fn (Pista $p) => $p->toProjectShowcaseItem())
            ->values()
            ->all();

        return view('inici.index', compact('comunitats', 'projectShowcaseItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
