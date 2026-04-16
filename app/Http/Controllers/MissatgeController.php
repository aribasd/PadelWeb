<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Missatge;
use App\Models\Comunitat;

class MissatgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Comunitat $comunitat)
    {
        $missatges = Missatge::query()
            ->where('comunitat_id', $comunitat->id)
            ->with('user')
            ->latest()
            ->paginate(50);

        return view('comunitats.missatges', compact('comunitat', 'missatges'));
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
    public function store(Request $request, Comunitat $comunitat)
    {
        $request->validate([
            'missatge' => 'required|string|max:255',
        ]);

        $user = $request->user();
        abort_unless($user, 403); // Si no està autenticat, no pot enviar missatges.

        Missatge::create([
            'comunitat_id' => $comunitat->id,
            'user_id' => $user->id,
            'missatge' => $request->input('missatge'),
        ]); 

        return redirect()->route('comunitats.missatges', $comunitat);
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
