<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeria; 
class GaleriaController extends Controller
{
    public function index()
    {
        // Vista demo amb React + imatges estàtiques; quan vulguis: Galeria::all() i passar URLs a React (JSON)
        return view('galeria.index');
    }

    public function create()
    {
        return view('galeria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'imatge' => 'required|image|max:5120',
        ]);

        $validated['imatge'] = $request->file('imatge')->store('galeria', 'public');

        Galeria::create($validated);

        return redirect()->route('galeria.index');
    }

    public function edit(string $id)
    {
        $galeria = Galeria::findOrFail($id);
        return view('galeria.edit', compact('galeria'));
    }
    


    public function update(Request $request, string $id)
    {
        $request->validate([
            'imatge' => 'required|image|max:5120',
        ]);

        $galeria = Galeria::findOrFail($id);
        $galeria->update($request->only(['imatge']));
    }

    public function destroy(string $id)
    {
        $galeria = Galeria::findOrFail($id);
        $galeria->delete();

        return redirect()->route('galeria.index');
    }
}
