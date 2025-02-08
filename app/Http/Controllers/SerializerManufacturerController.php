<?php

namespace App\Http\Controllers;

use App\Http\Requests\SerializerManufacturerRequest;
use App\Models\SerializerManufacturer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SerializerManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('viewAny', SerializerManufacturer::class);

        return view('serializer_manufacturers.index', [
            'breadcrumbs' => [
                route('index') => 'Home',
                'current' => 'Serializer manufacturers',
            ],
            'serializerManufacturers' => SerializerManufacturer::with([
                'createdBy',
                'updatedBy',
            ])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Gate::authorize('create', SerializerManufacturer::class);

        return view('serializer_manufacturers.create-or-edit', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('serializer_manufacturers.index') => 'Serializer manufacturers',
                'current' => 'Create',
            ],
            'serializerManufacturer' => new SerializerManufacturer,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SerializerManufacturerRequest $request): RedirectResponse
    {
        Gate::authorize('create', SerializerManufacturer::class);

        $validated = $request->validated();

        $serializerManufacturer = new SerializerManufacturer;

        $serializerManufacturer->id = strtoupper($validated['id']);
        $serializerManufacturer->name = $validated['name'];

        $serializerManufacturer->save();

        return redirect()
            ->route('serializer_manufacturers.edit', ['serializer_manufacturer' => $serializerManufacturer->id])
            ->with('success', sprintf('Serializer manufacturer %s created', $serializerManufacturer->name));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SerializerManufacturer $serializerManufacturer): View
    {
        Gate::authorize('update', $serializerManufacturer);

        return view('serializer_manufacturers.create-or-edit', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('serializer_manufacturers.index') => 'Serializer manufacturers',
                'current' => 'Edit serializer manufacturer '.Str::limit($serializerManufacturer->name, 30),
            ],
            'serializerManufacturer' => $serializerManufacturer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SerializerManufacturerRequest $request, SerializerManufacturer $serializerManufacturer): RedirectResponse
    {
        Gate::authorize('update', $serializerManufacturer);

        $validated = $request->validated();

        $serializerManufacturer->id = strtoupper($validated['id']);
        $serializerManufacturer->name = $validated['name'];

        $serializerManufacturer->save();

        return redirect()
            ->route('serializer_manufacturers.edit', ['serializer_manufacturer' => $serializerManufacturer->id])
            ->with('success', sprintf('Serializer manufacturer %s updated', $serializerManufacturer->name));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SerializerManufacturer $serializerManufacturer): RedirectResponse
    {
        Gate::authorize('delete', $serializerManufacturer);

        if ($serializerManufacturer->infotainments->isNotEmpty()) {
            return redirect()
                ->route('serializer_manufacturers.index')
                ->with('error', sprintf('Serializer manufacturer %s can\'t be deleted because it is assigned to some infotainments', $serializerManufacturer->name));
        }

        $serializerManufacturer->delete();

        return redirect()
            ->route('serializer_manufacturers.index')
            ->with('success', sprintf('Serializer manufacturer %s deleted', $serializerManufacturer->name));
    }
}
