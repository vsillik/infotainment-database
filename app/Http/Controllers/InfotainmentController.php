<?php

namespace App\Http\Controllers;

use App\Http\Requests\InfotainmentRequest;
use App\Models\Infotainment;
use App\Models\InfotainmentManufacturer;
use App\Models\SerializerManufacturer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InfotainmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('infotainments.index', [
            'infotainments' => Infotainment::with([
                'infotainmentManufacturer',
                'serializerManufacturer'
            ])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('infotainments.create-or-edit', [
            'infotainment' => new Infotainment,
            'infotainmentManufacturers' => InfotainmentManufacturer::all(),
            'serializerManufacturers' => SerializerManufacturer::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InfotainmentRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $infotainment = new Infotainment;

        $this->setInfotainmentValidatedValues($infotainment, $validated);

        return redirect()
            ->route('infotainments.show', ['infotainment' => $infotainment->id])
            ->with('success', 'Infotainment created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Infotainment $infotainment): View
    {
        return view('infotainments.show', [
            'infotainment' => $infotainment,
           'infotainmentProfiles' => $infotainment->profiles,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Infotainment $infotainment): View
    {
        return view('infotainments.create-or-edit', [
            'infotainment' => $infotainment,
            'infotainmentManufacturers' => InfotainmentManufacturer::all(),
            'serializerManufacturers' => SerializerManufacturer::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InfotainmentRequest $request, Infotainment $infotainment): RedirectResponse
    {
        $validated = $request->validated();

        $this->setInfotainmentValidatedValues($infotainment, $validated);

        return redirect()
            ->route('infotainments.show', ['infotainment' => $infotainment->id])
            ->with('success', 'Infotainment updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Infotainment $infotainment): RedirectResponse
    {
        $infotainment->delete();

        return redirect()
            ->route('infotainments.index')
            ->with('success', sprintf('Infotainment ID: %d deleted', $infotainment->id));
    }

    private function setInfotainmentValidatedValues(Infotainment $infotainment, mixed $validated): void
    {
        $infotainment->infotainmentManufacturer()->associate($validated['infotainment_manufacturer_id']);
        $infotainment->serializerManufacturer()->associate($validated['serializer_manufacturer_id']);
        $infotainment->product_id = $validated['product_id'];
        $infotainment->model_year = $validated['model_year'];
        $infotainment->part_number = $validated['part_number'];
        $infotainment->compatible_platforms = $validated['compatible_platforms'];
        $infotainment->internal_code = $validated['internal_code'];
        $infotainment->internal_notes = $validated['internal_notes'];

        $infotainment->save();
    }
}
