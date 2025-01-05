<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Infotainment;
use App\Models\User;
use App\UserRole;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', User::class);

        return view('users.index', [
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', User::class);

        return view('users.create-or-edit', [
            'user' => new User,
            'roles' => UserRole::labels(),
            'infotainments' => Infotainment::all()->pluck('product_id', 'id')->toArray(),
            'selectedInfotainments' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
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

        $user->infotainments()->sync($validated['infotainments']);

        return redirect()
            ->route('users.index')
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

        if (!$user->is_approved) {
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
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize('update', $user);

        return view('users.create-or-edit', [
            'user' => $user,
            'roles' => UserRole::labels(),
            'infotainments' => Infotainment::all()->pluck('product_id', 'id')->toArray(),
            'selectedInfotainments' => $user->infotainments->pluck('id')->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
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

        $user->infotainments()->sync($validated['infotainments']);

        return redirect()
            ->route('users.index')
            ->with('success', sprintf('User %s updated', $user->email));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', sprintf('User %s deleted', $user->email));
    }
}
