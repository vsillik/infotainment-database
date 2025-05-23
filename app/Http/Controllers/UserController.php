<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Filters\DeletedUsersFilter;
use App\Filters\Exceptions\InvalidFilterValueException;
use App\Filters\UsersFilter;
use App\Http\Requests\UserAssignInfotainmentsRequest;
use App\Http\Requests\UserRequest;
use App\Models\Infotainment;
use App\Models\User;
use App\Notifications\ApprovedNotification;
use App\Paginator\Exceptions\InvalidPageException;
use App\Paginator\Paginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Show users
     */
    public function index(Request $request): RedirectResponse|View
    {
        Gate::authorize('viewAny', User::class);

        /** @var array<string, ?string> $filters */
        $filters = [
            'email' => $request->query('email'),
            'name' => $request->query('name'),
            'approved' => $request->query('approved'),
            'user_role' => $request->query('user_role'),
        ];

        $perPageQuery = $request->query('per_page');
        if (is_array($perPageQuery)) {
            $perPageQuery = null;
        }

        try {
            $usersFilter = new UsersFilter($filters);
            $usersQuery = User::query();
            $filteredUsersQuery = $usersFilter->apply($usersQuery);

            $users = Paginator::paginate($filteredUsersQuery, $perPageQuery);
            $hasActiveFilters = $usersFilter->isAnyFilterSet();
        } catch (InvalidPageException) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Invalid page number');
        } catch (InvalidFilterValueException) {
            $users = Paginator::emptyPagination();
            $hasActiveFilters = true;
        }

        return view('users.index', [
            'breadcrumbs' => [
                route('index') => 'Home',
                'current' => 'Users',
            ],
            'perPageQuery' => $perPageQuery,
            'filters' => $filters,
            'hasActiveFilters' => $hasActiveFilters,
            'users' => $users,
            'userRoles' => ['any' => 'Any'] + UserRole::labels(),
        ]);
    }

    /**
     * Show form for creating user
     */
    public function create(): View
    {
        Gate::authorize('create', User::class);

        return view('users.create-or-edit', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('users.index') => 'Users',
                'current' => 'Create',
            ],
            'user' => new User,
            'roles' => UserRole::labels(),
        ]);
    }

    /**
     * Store new user
     */
    public function store(UserRequest $request): RedirectResponse
    {
        Gate::authorize('create', User::class);

        /** @var array{name: string, email: string, password: string, role: UserRole, internal_notes?: ?string} $validated */
        $validated = $request->validated();

        $user = new User;

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->role = $validated['role'];
        $user->internal_notes = $validated['internal_notes'] ?? null;
        $user->is_approved = false;

        $user->save();

        return redirect()
            ->route('users.show', $user)
            ->with('success', 'User created');
    }

    /**
     * Show specific user
     */
    public function show(User $user): View
    {
        Gate::authorize('view', $user);

        return view('users.show', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('users.index') => 'Users',
                'current' => $user->email,
            ],
            'user' => $user,
        ]);
    }

    /**
     * Approve user
     */
    public function approve(User $user): RedirectResponse
    {
        Gate::authorize('approve', $user);

        if ($user->is_approved) {
            return redirect()
                ->back()
                ->with('error', sprintf('User %s is already approved', $user->email));
        }

        $user->is_approved = true;
        $user->save();

        $user->notify(new ApprovedNotification);

        return redirect()
            ->back()
            ->with('success', sprintf('User %s approved', $user->email));
    }

    /**
     * Unapprove user
     */
    public function unapprove(User $user): RedirectResponse
    {
        Gate::authorize('unapprove', $user);

        if (! $user->is_approved) {
            return redirect()
                ->back()
                ->with('error', sprintf('User %s is not approved', $user->email));
        }

        $user->is_approved = false;
        $user->save();

        return redirect()
            ->back()
            ->with('success', sprintf('User %s approval revoked', $user->email));
    }

    /**
     * Show form for editing user
     */
    public function edit(User $user): View
    {
        Gate::authorize('update', $user);

        return view('users.create-or-edit', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('users.index') => 'Users',
                route('users.show', $user) => $user->email,
                'current' => 'Edit',
            ],
            'user' => $user,
            'roles' => UserRole::labels(),
        ]);
    }

    /**
     * Update user
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        Gate::authorize('update', $user);

        /** @var array{name: string, email: string, password: ?string, role: UserRole, internal_notes?: ?string} $validated */
        $validated = $request->validated();

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->has('password') && $validated['password'] !== null) {
            $user->password = Hash::make($validated['password']);
        }

        $user->role = $validated['role'];
        $user->internal_notes = $validated['internal_notes'] ?? null;

        $user->save();

        return redirect()
            ->route('users.show', ['user' => $user->id])
            ->with('success', sprintf('User %s updated', $user->email));
    }

    /**
     * Soft delete the user
     */
    public function destroy(User $user): RedirectResponse
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', sprintf('User %s marked as deleted', $user->email));
    }

    /**
     * Show soft deleted users
     */
    public function indexDeleted(Request $request): RedirectResponse|View
    {
        Gate::authorize('viewAny', User::class);

        /** @var array<string, ?string> $filters */
        $filters = [
            'email' => $request->query('email'),
            'name' => $request->query('name'),
            'user_role' => $request->query('user_role'),
            'deleted_from' => $request->query('deleted_from'),
            'deleted_to' => $request->query('deleted_to'),
        ];

        $perPageQuery = $request->query('per_page');
        if (is_array($perPageQuery)) {
            $perPageQuery = null;
        }

        try {
            $deletedUsersFilter = new DeletedUsersFilter($filters);
            $usersQuery = User::onlyTrashed()->with(['deletedBy']);

            $filteredUsersQuery = $deletedUsersFilter->apply($usersQuery);

            $users = Paginator::paginate($filteredUsersQuery, $perPageQuery);
            $hasActiveFilters = $deletedUsersFilter->isAnyFilterSet();
        } catch (InvalidPageException) {
            return redirect()
                ->route('users.deleted')
                ->with('error', 'Invalid page number');
        } catch (InvalidFilterValueException) {
            $users = Paginator::emptyPagination();
            $hasActiveFilters = true;
        }

        return view('users.index-deleted', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('users.index') => 'Users',
                'current' => 'Deleted users',
            ],
            'perPageQuery' => $perPageQuery,
            'filters' => $filters,
            'hasActiveFilters' => $hasActiveFilters,
            'users' => $users,
            'userRoles' => ['any' => 'Any'] + UserRole::labels(),
        ]);
    }

    /**
     * Restore soft deleted user
     */
    public function restore(User $user): RedirectResponse
    {
        Gate::authorize('restore', $user);

        if (! $user->trashed()) {
            return redirect()
                ->route('users.deleted')
                ->with('error', sprintf('User %s is already restored', $user->email));
        }

        $user->restore();

        return redirect()
            ->route('users.deleted')
            ->with('success', sprintf('User %s restored', $user->email));
    }

    /**
     * Permanently remove the user
     */
    public function forceDestroy(User $user): RedirectResponse
    {
        Gate::authorize('forceDelete', $user);

        if (! $user->trashed()) {
            return redirect()
                ->route('users.index')
                ->with('error', sprintf('User %s must be first marked as deleted', $user->email));
        }

        $user->forceDelete();

        return redirect()
            ->route('users.deleted')
            ->with('success', sprintf('User %s permanently deleted', $user->email));
    }

    /**
     * Show form for assigning infotainments to the user
     */
    public function assignInfotainments(User $user): View
    {
        Gate::authorize('assignInfotainments', $user);

        return view('users.assign-infotainments', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('users.index') => 'Users',
                route('users.show', $user) => $user->email,
                'current' => 'Assign infotainments',
            ],
            'user' => $user,
            'roles' => UserRole::labels(),
            'infotainments' => Infotainment::all(),
            'assignedInfotainments' => $user->infotainments->pluck('id'),
        ]);
    }

    /**
     * Update assignment of infotainments for the user
     */
    public function updateAssignedInfotainments(UserAssignInfotainmentsRequest $request, User $user): RedirectResponse
    {
        Gate::authorize('assignInfotainments', $user);

        /** @var array{infotainments: array<int>} $validated */
        $validated = $request->validated();

        $infotainments = $request->has('infotainments') ? $validated['infotainments'] : [];

        $user->infotainments()->sync($infotainments);

        return redirect()
            ->route('users.assign-infotainments', ['user' => $user->id])
            ->with('success', sprintf('User %s infotainments assignment updated', $user->email));
    }
}
