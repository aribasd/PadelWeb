<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comunitat;

class ComunitatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comunitats = Comunitat::all();
        return view('comunitats.index', compact('comunitats'));
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
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        Comunitat::create($request->only('nom'));

        return redirect()->route('comunitats.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comunitat = Comunitat::findOrFail($id);
        return view('comunitats.show', compact('comunitat'));
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
        $comunitat->update($request->only('nom'));

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