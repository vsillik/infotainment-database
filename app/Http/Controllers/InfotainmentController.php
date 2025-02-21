<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Filters\Exceptions\InvalidFilterValueException;
use App\Filters\InfotainmentsFilter;
use App\Http\Requests\InfotainmentRequest;
use App\Http\Requests\InfotainmentsAssignUsersRequest;
use App\Models\Infotainment;
use App\Models\InfotainmentManufacturer;
use App\Models\InfotainmentProfile;
use App\Models\SerializerManufacturer;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 * @phpstan-type InfotainmentValidatedValues array{
 *     infotainment_manufacturer_id: int,
 *     serializer_manufacturer_id: int,
 *     product_id: string,
 *     model_year: int,
 *     part_number: string,
 *     compatible_platforms?: ?string,
 *     internal_code?: ?string,
 *     internal_notes?: ?string,
 * }
 */
class InfotainmentController extends Controller
{
    /**
     * Show infotainments
     */
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Infotainment::class);

        /** @var User $user because user must be logged in, this won't be null */
        $user = $request->user();

        /** @var array<string, ?string> $filters */
        $filters = [
            'infotainment_manufacturer_name' => $request->query('infotainment_manufacturer_name'),
            'serializer_manufacturer_name' => $request->query('serializer_manufacturer_name'),
            'product_id' => $request->query('product_id'),
            'model_year_from' => $request->query('model_year_from'),
            'model_year_to' => $request->query('model_year_to'),
            'part_number' => $request->query('part_number'),
        ];

        try {
            $infotainmentsFilter = new InfotainmentsFilter($filters);

            if ($user->role === UserRole::CUSTOMER) {
                $infotainmentsQuery = $user->infotainments()
                    ->with([
                        'infotainmentManufacturer',
                        'serializerManufacturer',
                    ])->getQuery();
            } else {
                $infotainmentsQuery = Infotainment::with([
                    'infotainmentManufacturer',
                    'serializerManufacturer',
                ]);
            }

            $infotainments = $infotainmentsFilter->apply($infotainmentsQuery)
                ->paginate(Config::integer('app.items_per_page'))->withQueryString();

            $hasActiveFilters = $infotainmentsFilter->isAnyFilterSet();
        } catch (InvalidFilterValueException) {
            $infotainments = new LengthAwarePaginator([], 0, Config::integer('app.items_per_page'));
            $hasActiveFilters = true;
        }

        return view('infotainments.index', [
            'breadcrumbs' => [
                route('index') => 'Home',
                'current' => 'Infotainments',
            ],
            'filters' => $filters,
            'hasActiveFilters' => $hasActiveFilters,
            'infotainments' => $infotainments,
            'displayAdvancedColumns' => $user->role->value > UserRole::CUSTOMER->value,
        ]);
    }

    /**
     * Show form for creating infotainment
     */
    public function create(): View|RedirectResponse
    {
        Gate::authorize('create', Infotainment::class);

        $infotainmentManufacturers = InfotainmentManufacturer::pluck('name', 'id')->toArray();

        if (count($infotainmentManufacturers) === 0) {
            return redirect()
                ->route('infotainments.index')
                ->with('error', 'In order to create infotainment you first need to have at least one infotainment manufacturer created.');
        }

        $serializerManufacturers = SerializerManufacturer::pluck('name', 'id')->toArray();

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
     * Store new infotainment
     */
    public function store(InfotainmentRequest $request): RedirectResponse
    {
        Gate::authorize('create', Infotainment::class);

        /** @var InfotainmentValidatedValues $validated */
        $validated = $request->validated();

        $infotainment = new Infotainment;

        $this->setInfotainmentValidatedValues($infotainment, $validated);

        return redirect()
            ->route('infotainments.show', ['infotainment' => $infotainment->id])
            ->with('success', 'Infotainment created');
    }

    /**
     * Show specific infotainment
     */
    public function show(Request $request, Infotainment $infotainment): View
    {
        Gate::authorize('view', $infotainment);

        /** @var User $user because user must be logged in, this won't be null */
        $user = $request->user();
        $userRole = $user->role;
        $onlyUnapprovedProfiles = false;

        if ($userRole === UserRole::CUSTOMER) {
            $view = 'infotainments.customer-show';

            $infotainmentProfiles = $infotainment->profiles()
                ->where('is_approved', true)
                ->orderByDesc('id')
                ->get();

            if ($infotainmentProfiles->isEmpty()) {
                $infotainmentProfiles = $infotainment->profiles()
                    ->where('is_approved', false)
                    ->orderByDesc('id')
                    ->get();
                $onlyUnapprovedProfiles = true;
            }
        } else {
            $view = 'infotainments.show';

            $infotainmentProfiles = $infotainment->profiles()
                ->with([
                    'extraTiming',
                    'createdBy',
                    'updatedBy',
                ])
                ->orderByDesc('id')
                ->get();
        }

        return view($view, [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('infotainments.index') => 'Infotainments',
                'current' => 'Infotainment ID: '.$infotainment->id,
            ],
            'infotainment' => $infotainment,
            'infotainmentProfiles' => $infotainmentProfiles,
            'profileNumbers' => InfotainmentProfile::mapIdsToProfileNumbers($infotainment),
            'onlyUnapprovedProfiles' => $onlyUnapprovedProfiles,
        ]);
    }

    /**
     * Show form editing of the infotainment
     */
    public function edit(Infotainment $infotainment): View
    {
        Gate::authorize('update', $infotainment);

        return view('infotainments.create-or-edit', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('infotainments.index') => 'Infotainments',
                'current' => 'Edit infotainment ID: '.$infotainment->id,
            ],
            'infotainment' => $infotainment,
            'infotainmentManufacturers' => InfotainmentManufacturer::pluck('name', 'id')->toArray(),
            'serializerManufacturers' => SerializerManufacturer::pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Update the infotainment
     */
    public function update(InfotainmentRequest $request, Infotainment $infotainment): RedirectResponse
    {
        Gate::authorize('update', $infotainment);

        /** @var InfotainmentValidatedValues $validated */
        $validated = $request->validated();

        $this->setInfotainmentValidatedValues($infotainment, $validated);

        return redirect()
            ->route('infotainments.edit', ['infotainment' => $infotainment->id])
            ->with('success', 'Infotainment updated');
    }

    /**
     * Remove the infotainment
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

    /**
     * Show form for mass assigning users to the infotainments
     */
    public function assignUsers(Request $request): View|RedirectResponse
    {
        Gate::authorize('assignUsers', Infotainment::class);

        $infotainmentIdsInput = $request->string('infotainments', '')->toString();

        $infotainmentIds = explode(',', $infotainmentIdsInput);

        if ($infotainmentIds === ['']) {
            return redirect()
                ->route('infotainments.index')
                ->with('error', 'You first need to select at least one infotainment');
        }

        $infotainments = Infotainment::whereIn('id', $infotainmentIds)
            ->with([
                'infotainmentManufacturer',
                'serializerManufacturer',
            ])
            ->get();

        if (count($infotainments) !== count($infotainmentIds)) {
            return redirect()
                ->route('infotainments.index')
                ->with('error', 'Some of the specified infotainments were not found');
        }

        $users = User::where('role', UserRole::CUSTOMER)
            ->where('is_approved', true)
            ->get();

        if ($users->isEmpty()) {
            return redirect()
                ->route('infotainments.index')
                ->with('error', 'There are no available customers');
        }

        return view('infotainments.assign-users', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('infotainments.index') => 'Infotainments',
                'current' => 'Assign users to infotainments',
            ],
            'infotainments' => $infotainments,
            'users' => $users,
        ]);
    }

    /**
     * Assign selected users to selected infotainments
     */
    public function addAssignedUsers(InfotainmentsAssignUsersRequest $request): RedirectResponse
    {
        Gate::authorize('assignUsers', Infotainment::class);

        $validated = $request->validated();

        /** @var array{infotainments: array<int>, users: array<int>} $validated */
        $assignments = [];

        foreach ($validated['infotainments'] as $infotainment_id) {
            foreach ($validated['users'] as $user_id) {
                $assignments[] = [
                    'infotainment_id' => $infotainment_id,
                    'user_id' => $user_id,
                ];
            }
        }

        DB::table('infotainment_user')->upsert(
            $assignments,
            ['infotainment_id', 'user_id'],
        );

        return redirect()
            ->route('infotainments.index')
            ->with('success', 'Users were assigned to selected infotainments');
    }

    /**
     * @param  InfotainmentValidatedValues  $validated
     */
    private function setInfotainmentValidatedValues(Infotainment $infotainment, array $validated): void
    {
        $infotainment->infotainmentManufacturer()->associate($validated['infotainment_manufacturer_id']);
        $infotainment->serializerManufacturer()->associate($validated['serializer_manufacturer_id']);
        $infotainment->product_id = str_pad($validated['product_id'], 4, '0', STR_PAD_LEFT);
        $infotainment->model_year = $validated['model_year'];
        $infotainment->part_number = $validated['part_number'];
        $infotainment->compatible_platforms = $validated['compatible_platforms'] ?? null;
        $infotainment->internal_code = $validated['internal_code'] ?? null;
        $infotainment->internal_notes = $validated['internal_notes'] ?? null;

        $infotainment->save();
    }
}
