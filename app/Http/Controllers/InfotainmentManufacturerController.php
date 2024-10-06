<?php

namespace App\Http\Controllers;

use App\Http\Requests\InfotainmentManufacturerRequest;
use App\Models\InfotainmentManufacturer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InfotainmentManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('infotainment_manufacturers.index', [
            'infotainmentManufacturers' => InfotainmentManufacturer::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('infotainment_manufacturers.create-or-edit', [
            'infotainment_manufacturers' => new InfotainmentManufacturer,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InfotainmentManufacturerRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $infotainmentManufacturer = new InfotainmentManufacturer;

        $infotainmentManufacturer->name = $validated['name'];

        $infotainmentManufacturer->save();

        return redirect()
            ->route('infotainment_manufacturers.index')
            ->with('success', sprintf('Infotainment manufacturer %s created', $infotainmentManufacturer->name));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InfotainmentManufacturer $infotainmentManufacturer): View
    {
        return view('infotainment_manufacturers.create-or-edit', ['infotainment_manufacturers' => $infotainmentManufacturer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InfotainmentManufacturerRequest $request, InfotainmentManufacturer $infotainmentManufacturer): RedirectResponse
    {
        $validated = $request->validated();

        $infotainmentManufacturer->name = $validated['name'];

        $infotainmentManufacturer->save();

        return redirect()
            ->route('infotainment_manufacturers.index')
            ->with('success', sprintf('Infotainment manufacturer %s updated', $infotainmentManufacturer->name));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InfotainmentManufacturer $infotainmentManufacturer): RedirectResponse
    {
        $infotainmentManufacturer->delete();

        return redirect()
            ->route('infotainment_manufacturers.index')
            ->with('success', sprintf('Infotainment manufacturer %s deleted', $infotainmentManufacturer->name));
    }
}
