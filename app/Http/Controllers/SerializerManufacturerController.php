<?php

namespace App\Http\Controllers;

use App\Filters\Exceptions\InvalidFilterValueException;
use App\Filters\SerializerManufacturersFilter;
use App\Http\Requests\SerializerManufacturerRequest;
use App\Models\SerializerManufacturer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SerializerManufacturerController extends Controller
{
    /**
     * Show serializer manufacturers
     */
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', SerializerManufacturer::class);

        /** @var array<string, ?string> $filters */
        $filters = [
            'identifier' => $request->query('identifier'),
            'name' => $request->query('name'),
            'created_from' => $request->query('created_from'),
            'created_to' => $request->query('created_to'),
            'updated_from' => $request->query('updated_from'),
            'updated_to' => $request->query('updated_to'),
        ];

        try {
            $serializerManufacturersFilter = new SerializerManufacturersFilter($filters);
            $serializerManufacturersQuery = SerializerManufacturer::with([
                'createdBy',
                'updatedBy',
            ]);
            $serializerManufacturers = $serializerManufacturersFilter
                ->apply($serializerManufacturersQuery)
                ->paginate(Config::integer('app.items_per_page'))->withQueryString();
            $hasActiveFilters = $serializerManufacturersFilter->isAnyFilterSet();
        } catch (InvalidFilterValueException) {
            $serializerManufacturers = new LengthAwarePaginator([], 0, Config::integer('app.items_per_page'));
            $hasActiveFilters = true;
        }

        return view('serializer_manufacturers.index', [
            'breadcrumbs' => [
                route('index') => 'Home',
                'current' => 'Serializer manufacturers',
            ],
            'filters' => $filters,
            'hasActiveFilters' => $hasActiveFilters,
            'serializerManufacturers' => $serializerManufacturers,
        ]);
    }

    /**
     * Show form for creating new serializer manufacturer
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
     * Store new serializer manufacturer
     */
    public function store(SerializerManufacturerRequest $request): RedirectResponse
    {
        Gate::authorize('create', SerializerManufacturer::class);

        /** @var array{id: string, name: string} $validated */
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
     * Show form for editing serializer manufacturer
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
     * Update the serializer manufacturer
     */
    public function update(SerializerManufacturerRequest $request, SerializerManufacturer $serializerManufacturer): RedirectResponse
    {
        Gate::authorize('update', $serializerManufacturer);

        /** @var array{id: string, name: string} $validated */
        $validated = $request->validated();

        $serializerManufacturer->id = strtoupper($validated['id']);
        $serializerManufacturer->name = $validated['name'];

        $serializerManufacturer->save();

        return redirect()
            ->route('serializer_manufacturers.edit', ['serializer_manufacturer' => $serializerManufacturer->id])
            ->with('success', sprintf('Serializer manufacturer %s updated', $serializerManufacturer->name));
    }

    /**
     * Remove the serializer manufacturer
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
