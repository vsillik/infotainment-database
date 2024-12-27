<?php

namespace App\Http\Controllers;

use App\Http\Requests\SerializerManufacturerRequest;
use App\Models\SerializerManufacturer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SerializerManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('serializer_manufacturers.index', [
            'serializerManufacturers' => SerializerManufacturer::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('serializer_manufacturers.create-or-edit', [
           'serializerManufacturer' => new SerializerManufacturer,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SerializerManufacturerRequest $request): RedirectResponse
    {
       $validated = $request->validated();

       $serializerManufacturer = new SerializerManufacturer;

       $serializerManufacturer->id = $validated['id'];
       $serializerManufacturer->name = $validated['name'];

       $serializerManufacturer->save();

       return redirect()
           ->route('serializer_manufacturers.index')
           ->with('success', sprintf('Serializer manufacturer %s created', $serializerManufacturer->name));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SerializerManufacturer $serializerManufacturer): View
    {
        return view('serializer_manufacturers.create-or-edit', [
            'serializerManufacturer' => $serializerManufacturer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SerializerManufacturerRequest $request, SerializerManufacturer $serializerManufacturer): RedirectResponse
    {
        $validated = $request->validated();

        $serializerManufacturer->id = $validated['id'];
        $serializerManufacturer->name = $validated['name'];

        $serializerManufacturer->save();

        return redirect()
            ->route('serializer_manufacturers.index')
            ->with('success', sprintf('Serializer manufacturer %s updated', $serializerManufacturer->name));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SerializerManufacturer $serializerManufacturer): RedirectResponse
    {
        if ($serializerManufacturer->infotainments->isNotEmpty()) {
            return redirect()
                ->route('serializer_manufacturers.index')
                ->with('error', sprintf('Serializer manufacturer %s can\'t be deleted because it is assigned to infotainments', $serializerManufacturer->name));
        }

        $serializerManufacturer->delete();

        return redirect()
            ->route('serializer_manufacturers.index')
            ->with('success', sprintf('Serializer manufacturer %s deleted', $serializerManufacturer->name));
    }
}
