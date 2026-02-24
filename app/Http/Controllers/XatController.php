<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Xat;

class XatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $xats = Xat::all();
        return view('xats.index', compact('xats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('xats.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Aquí pots afegir validació si afegeixes camps al model
        Xat::create($request->only([
            // omple amb els camps que afegeixis després
        ]));

        return redirect()->route('xats.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $xat = Xat::findOrFail($id);
        return view('xats.show', compact('xat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $xat = Xat::findOrFail($id);
        return view('xats.edit', compact('xat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $xat = Xat::findOrFail($id);

        // Aquí pots afegir validació si afegeixes camps
        $xat->update($request->only([
            // omple amb els camps que afegeixis després
        ]));

        return redirect()->route('xats.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $xat = Xat::findOrFail($id);
        $xat->delete();

        return redirect()->route('xats.index');
    }
}