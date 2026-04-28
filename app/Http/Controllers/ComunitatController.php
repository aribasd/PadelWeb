<?php

namespace App\Http\Controllers;


use App\Models\Comunitat;
use App\Models\User;
use App\Services\NivellService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComunitatController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comunitats = Comunitat::withCount('users')
            ->orderBy('nom')
            ->paginate(12);
        $mevesIds = Auth::check()
            ? Auth::user()->comunitats()->pluck('comunitats.id')->all()
            : [];

        return view('comunitats.index', [
            'comunitats' => $comunitats,
            'subheaderTitol' => 'Comunitats',
            'esLlistaMeves' => false,
            'mevesIds' => $mevesIds,
        ]);
    }

    /**
     * Comunitats on l'usuari autenticat és membre (taula pivot comunitat_user).
     */
    public function meves()
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 403);

        $comunitats = $user->comunitats()
            ->withCount('users')
            ->orderBy('nom')
            ->paginate(12);
        $mevesIds = $comunitats->getCollection()->pluck('id')->all();

        return view('comunitats.index', [
            'comunitats' => $comunitats,
            'subheaderTitol' => 'Les meves comunitats',
            'esLlistaMeves' => true,
            'mevesIds' => $mevesIds,
        ]);
    }

    /**
     * L'usuari autenticat s'uneix a una comunitat.
     */
    public function join(Request $request, Comunitat $comunitat)
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);

        $comunitat->users()->syncWithoutDetaching([
            $user->id => ['rol' => 'usuari'],
        ]);

        // XP per unir-se a una comunitat
        app(NivellService::class)->awardXp($user, 50);

        return back();
    }

    /**
     * L'usuari autenticat surt d'una comunitat.
     */
    public function leave(Request $request, Comunitat $comunitat)
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);

        $comunitat->users()->detach($user->id);

        return back();
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
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'descripcio' => 'required|string|max:255',
            'direccio' => 'nullable|string|max:255',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'imatge' => 'required|image|max:5120',
            'rol' => 'required|in:admin,moderador,usuari',
        ]);

        $validated['imatge'] = $request->file('imatge')->store('comunitats', 'public');

        $validated['membres'] = $validated['membres'] ?? '0';

        $comunitat = Comunitat::create($validated);

        if ($user = $request->user()) {
            $comunitat->users()->syncWithoutDetaching([
                $user->id => ['rol' => $validated['rol']],
            ]);
        }

        return redirect()->route('comunitats.show', $comunitat);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comunitat = Comunitat::query()
            ->with('pistes')
            ->findOrFail($id);

        $totalTrofeu10Reserves = $comunitat->users()
            ->whereHas('perfil_estadistiques.insignies', function ($q) {
                $q->where('nom', '10 reserves');
            })
            ->count();

        $usuaris = $comunitat->users()
            ->leftJoin('perfil_estadistiques', 'perfil_estadistiques.user_id', '=', 'users.id')
            ->select('users.*')
            ->with(['perfil_estadistiques.insignies'])
            ->orderByRaw('COALESCE(perfil_estadistiques.nivell, 1) DESC')
            ->orderBy('users.name')
            ->paginate(12);

        return view('comunitats.show', compact('comunitat', 'usuaris', 'totalTrofeu10Reserves'));
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
            'descripcio' => 'sometimes|string|max:255',
            'direccio' => 'nullable|string|max:255',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);

        $comunitat = Comunitat::findOrFail($id);
        $comunitat->update($request->only([
            'nom',
            'descripcio',
            'direccio',
            'lat',
            'lng',
        ]));

        return redirect()->route('comunitats.show', $comunitat);
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
