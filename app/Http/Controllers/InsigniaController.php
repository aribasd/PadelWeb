<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Insignia;

class InsigniaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $insignies = Insignia::all();
        return view('insignies.index', compact('insignies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('insignies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'dificultat' => 'required|in:baixa,mitjana,dificil',
        ]);

        Insignia::create($request->only([
            'nom',
            'dificultat',
        ]));

        return redirect()->route('insignies.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $insignia = Insignia::findOrFail($id);
        return view('insignies.edit', compact('insignia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'dificultat' => 'required|in:baixa,mitjana,dificil',
        ]);

        $insignia = Insignia::findOrFail($id);
        $insignia->update($request->only([
            'nom',
            'dificultat',
        ]));

        return redirect()->route('insignies.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $insignia = Insignia::findOrFail($id);
        $insignia->delete();

        return redirect()->route('insignies.index');
    }
}