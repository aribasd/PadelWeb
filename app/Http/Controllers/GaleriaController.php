<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeria; 
use App\Models\Comunitat;
use Illuminate\Support\Facades\Auth;

class GaleriaController extends Controller
{
    public function index(Request $request)
    {
        $comunitats = Comunitat::query()
            ->orderBy('nom')
            ->get(['id', 'nom']);

        $comunitatId = $request->integer('comunitat_id') ?: null;

        $uploadComunitats = collect();
        $authUser = Auth::user();
        if ($authUser) {
            $uploadComunitats = $authUser
                ->comunitats()
                ->wherePivot('rol', 'admin')
                ->orderBy('nom')
                ->get(['comunitats.id', 'nom']);
        }

        $imatges = Galeria::query()
            ->when($comunitatId, fn ($q) => $q->where('comunitat_id', $comunitatId))
            ->latest('id')
            ->with('comunitat')
            ->get();

        return view('galeria.index', compact('imatges', 'comunitats', 'comunitatId', 'uploadComunitats'));
    }

    public function create()
    {
        return view('galeria.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'imatge' => 'required|image|max:5120',
            'comunitat_id' => 'required|integer|exists:comunitats,id',
        ]);

        $user = $request->user();
        if (!$user) {
            abort(403);
        }

        $isCommunityAdmin = $user->comunitats()
            ->whereKey($validated['comunitat_id'])
            ->wherePivot('rol', 'admin')
            ->exists();
        if (!$isCommunityAdmin) {
            abort(403, 'Només els admins d’aquesta comunitat poden pujar fotos.');
        }

        $validated['imatge'] = $request->file('imatge')->store('galeria', 'public');

        Galeria::create($validated);

        return redirect()->route('galeria.index', ['comunitat_id' => $validated['comunitat_id']]);
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
