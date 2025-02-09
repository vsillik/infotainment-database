<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAssignInfotainmentsRequest;
use App\Http\Requests\UserRequest;
use App\Models\Infotainment;
use App\Models\User;
use App\UserRole;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
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

    public function create()
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

    public function store(UserRequest $request)
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

    public function approve(User $user)
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

    public function unapprove(User $user)
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

    public function edit(User $user)
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

    public function update(UserRequest $request, User $user)
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

    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', sprintf('User %s marked as deleted', $user->email));
    }

    public function indexDeleted()
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

    public function restore(User $user)
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

    public function forceDestroy(User $user)
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

    public function assignInfotainments(User $user)
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

    public function updateAssignedInfotainments(UserAssignInfotainmentsRequest $request, User $user)
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
