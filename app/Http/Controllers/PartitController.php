<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partit;

class PartitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partits = Partit::all();
        return view('partits.index', compact('partits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('partits.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom1' => 'required|string|max:255',
            'nom2' => 'required|string|max:255',
            'nom3' => 'required|string|max:255',
            'nom4' => 'required|string|max:255',
            'set1' => 'required|boolean',
            'set2' => 'required|boolean',
            'set3' => 'required|boolean',
        ]);

        Partit::create($request->only([
            'nom1', 'nom2', 'nom3', 'nom4', 'set1', 'set2', 'set3'
        ]));

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
            'nom1' => 'required|string|max:255',
            'nom2' => 'required|string|max:255',
            'nom3' => 'required|string|max:255',
            'nom4' => 'required|string|max:255',
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