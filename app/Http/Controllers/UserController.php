<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAssignInfotainmentsRequest;
use App\Http\Requests\UserRequest;
use App\Models\Infotainment;
use App\Models\User;
use App\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Show users
     */
    public function index(): View
    {
        Gate::authorize('viewAny', User::class);

        return view('users.index', [
            'breadcrumbs' => [
                route('index') => 'Home',
                'current' => 'Users',
            ],
            'users' => User::all(),
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

        $validated = $request->validated();

        $user = new User;

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->role = $validated['role'];
        $user->is_approved = false;

        $user->save();

        if ($request->has('infotainments')) {
            $user->infotainments()->sync($validated['infotainments']);
        }

        return redirect()
            ->route('users.edit', ['user' => $user->id])
            ->with('success', 'User created');
    }

    /**
     * Approve user
     */
    public function approve(User $user): RedirectResponse
    {
        Gate::authorize('approve', $user);

        if ($user->is_approved) {
            return redirect()
                ->route('users.index')
                ->with('error', sprintf('User %s is already approved', $user->email));
        }

        $user->is_approved = true;
        $user->save();

        return redirect()
            ->route('users.index')
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
                ->route('users.index')
                ->with('error', sprintf('User %s is not approved', $user->email));
        }

        $user->is_approved = false;
        $user->save();

        return redirect()
            ->route('users.index')
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
                'current' => 'Edit user '.Str::limit($user->email, 30),
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

        $validated = $request->validated();

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->has('password') && $validated['password'] !== null) {
            $user->password = Hash::make($validated['password']);
        }

        $user->role = $validated['role'];

        $user->save();

        $infotainments = $request->has('infotainments') ? $validated['infotainments'] : [];

        $user->infotainments()->sync($infotainments);

        return redirect()
            ->route('users.edit', ['user' => $user->id])
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
    public function indexDeleted(): View
    {
        Gate::authorize('viewAny', User::class);

        return view('users.index-deleted', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('users.index') => 'Users',
                'current' => 'Deleted users',
            ],
            'users' => User::onlyTrashed()
                ->with([
                    'deletedBy',
                ])
                ->get(),
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
                ->route('users.index')
                ->with('error', sprintf('User %s is already restored', $user->email));
        }

        $user->restore();

        return redirect()
            ->route('users.index')
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
            ->route('users.index')
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

        $validated = $request->validated();

        $infotainments = $request->has('infotainments') ? $validated['infotainments'] : [];

        $user->infotainments()->sync($infotainments);

        return redirect()
            ->route('users.assign-infotainments', ['user' => $user->id])
            ->with('success', sprintf('User %s infotainments assignment updated', $user->email));

    }
}
