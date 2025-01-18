<?php

namespace App\Http\Controllers;

use App\Http\Requests\InfotainmentRequest;
use App\Models\Infotainment;
use App\Models\InfotainmentManufacturer;
use App\Models\InfotainmentProfile;
use App\Models\SerializerManufacturer;
use App\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class InfotainmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Infotainment::class);

        if ($request->user()->role === UserRole::CUSTOMER) {
            $infotainments = $request->user()->infotainments->load([
                'infotainmentManufacturer',
                'serializerManufacturer',
            ]);
        } else {
            $infotainments = Infotainment::with([
                'infotainmentManufacturer',
                'serializerManufacturer',
            ])->get();
        }

        return view('infotainments.index', [
            'breadcrumbs' => [
                route('index') => 'Home',
                'current' => 'Infotainments',
            ],
            'infotainments' => $infotainments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|RedirectResponse
    {
        Gate::authorize('create', Infotainment::class);

        $infotainmentManufacturers = InfotainmentManufacturer::all()
            ->pluck('name', 'id')->toArray();

        if (count($infotainmentManufacturers) === 0) {
            return redirect()
                ->route('infotainments.index')
                ->with('error', 'In order to create infotainment you first need to have at least one infotainment manufacturer created.');
        }

        $serializerManufacturers = SerializerManufacturer::all()
        ->pluck('name', 'id')->toArray();

        if (count($serializerManufacturers) === 0) {
            return redirect()
                ->route('infotainments.index')
                ->with('error', 'In order to create infotainment you first need to have at least one serializer manufacturer created.');
        }

        return view('infotainments.create-or-edit', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('infotainments.index') => 'Infotainments',
                'current' => 'Create',
            ],
            'infotainment' => new Infotainment,
            'infotainmentManufacturers' => $infotainmentManufacturers,
            'serializerManufacturers' => $serializerManufacturers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InfotainmentRequest $request): RedirectResponse
    {
        Gate::authorize('create', Infotainment::class);

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
        Gate::authorize('view', $infotainment);

        return view('infotainments.show', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('infotainments.index') => 'Infotainments',
                'current' => 'Infotainment ID: ' . $infotainment->id,
            ],
            'infotainment' => $infotainment,
            'infotainmentProfiles' => $infotainment->profiles->sortByDesc('id'),
            'profileNumbers' => InfotainmentProfile::mapIdsToProfileNumbers($infotainment)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Infotainment $infotainment): View
    {
        Gate::authorize('update', $infotainment);

        return view('infotainments.create-or-edit', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('infotainments.index') => 'Infotainments',
                'current' => 'Edit infotainment ID: '. $infotainment->id,
            ],
            'infotainment' => $infotainment,
            'infotainmentManufacturers' => InfotainmentManufacturer::all()
                ->pluck('name', 'id')->toArray(),
            'serializerManufacturers' => SerializerManufacturer::all()
                ->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InfotainmentRequest $request, Infotainment $infotainment): RedirectResponse
    {
        Gate::authorize('update', $infotainment);

        $validated = $request->validated();

        $this->setInfotainmentValidatedValues($infotainment, $validated);

        return redirect()
            ->route('infotainments.edit', ['infotainment' => $infotainment->id])
            ->with('success', 'Infotainment updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Infotainment $infotainment): RedirectResponse
    {
        Gate::authorize('delete', $infotainment);

        if ($infotainment->profiles->isNotEmpty()) {
            return redirect()
                ->route('infotainments.index')
                ->with('error', sprintf('Infotainment ID: %s can\'t be deleted because it has profiles assigned', $infotainment->id));
        }

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
