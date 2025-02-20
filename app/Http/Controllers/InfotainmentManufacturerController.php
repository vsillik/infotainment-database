<?php

namespace App\Http\Controllers;

use App\Filters\InfotainmentManufacturersFilter;
use App\Http\Requests\InfotainmentManufacturerRequest;
use App\Models\InfotainmentManufacturer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InfotainmentManufacturerController extends Controller
{
    /**
     * Show infotainment manufacturers
     */
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', InfotainmentManufacturer::class);

        /** @var array<string, ?string> $filters */
        $filters = [
            'name' => $request->query('name'),
            'created_at' => $request->query('created_at'),
            'updated_at' => $request->query('updated_at'),
        ];

        $infotainmentManufacturersFilter = new InfotainmentManufacturersFilter($filters);
        $infotainmentManufacturersQuery = InfotainmentManufacturer::with([
            'createdBy',
            'updatedBy',
        ]);
        $infotainmentManufacturers = $infotainmentManufacturersFilter
            ->apply($infotainmentManufacturersQuery)
            ->paginate(Config::integer('app.items_per_page'))->withQueryString();

        return view('infotainment_manufacturers.index', [
            'breadcrumbs' => [
                route('index') => 'Home',
                'current' => 'Infotainment manufacturers',
            ],
            'filters' => $filters,
            'hasActiveFilters' => $infotainmentManufacturersFilter->isAnyFilterSet(),
            'infotainmentManufacturers' => $infotainmentManufacturers,
        ]);
    }

    /**
     * Show form for creating infotainment manufacturer
     */
    public function create(): View
    {
        Gate::authorize('create', InfotainmentManufacturer::class);

        return view('infotainment_manufacturers.create-or-edit', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('infotainment_manufacturers.index') => 'Infotainment manufacturers',
                'current' => 'Create',
            ],
            'infotainmentManufacturer' => new InfotainmentManufacturer,
        ]);
    }

    /**
     * Store new infotainment manufacturer
     */
    public function store(InfotainmentManufacturerRequest $request): RedirectResponse
    {
        Gate::authorize('create', InfotainmentManufacturer::class);

        /** @var array{name: string} $validated */
        $validated = $request->validated();

        $infotainmentManufacturer = new InfotainmentManufacturer;

        $infotainmentManufacturer->name = $validated['name'];

        $infotainmentManufacturer->save();

        return redirect()
            ->route('infotainment_manufacturers.edit', ['infotainment_manufacturer' => $infotainmentManufacturer->id])
            ->with('success', sprintf('Infotainment manufacturer %s created', $infotainmentManufacturer->name));
    }

    /**
     * Show form for editing of the infotainment manufacturer
     */
    public function edit(InfotainmentManufacturer $infotainmentManufacturer): View
    {
        Gate::authorize('update', $infotainmentManufacturer);

        return view('infotainment_manufacturers.create-or-edit', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('infotainment_manufacturers.index') => 'Infotainment manufacturers',
                'current' => 'Edit infotainment manufacturer '.Str::limit($infotainmentManufacturer->name, 30),
            ],
            'infotainmentManufacturer' => $infotainmentManufacturer,
        ]);
    }

    /**
     * Update the infotainment manufacturer
     */
    public function update(InfotainmentManufacturerRequest $request, InfotainmentManufacturer $infotainmentManufacturer): RedirectResponse
    {
        Gate::authorize('update', $infotainmentManufacturer);

        /** @var array{name: string} $validated */
        $validated = $request->validated();

        $infotainmentManufacturer->name = $validated['name'];

        $infotainmentManufacturer->save();

        return redirect()
            ->route('infotainment_manufacturers.edit', ['infotainment_manufacturer' => $infotainmentManufacturer->id])
            ->with('success', sprintf('Infotainment manufacturer %s updated', $infotainmentManufacturer->name));
    }

    /**
     * Remove the infotainment manufacturer
     */
    public function destroy(InfotainmentManufacturer $infotainmentManufacturer): RedirectResponse
    {
        Gate::authorize('delete', $infotainmentManufacturer);

        if ($infotainmentManufacturer->infotainments->isNotEmpty()) {
            return redirect()
                ->route('infotainment_manufacturers.index')
                ->with('error', sprintf('Infotainment manufacturer %s can\'t be deleted because it is assigned to some infotainments', $infotainmentManufacturer->name));
        }

        $infotainmentManufacturer->delete();

        return redirect()
            ->route('infotainment_manufacturers.index')
            ->with('success', sprintf('Infotainment manufacturer %s deleted', $infotainmentManufacturer->name));
    }
}
