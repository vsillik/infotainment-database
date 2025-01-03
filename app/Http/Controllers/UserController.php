<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index', [
            'users' => User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create-or-edit', [
            'user' => new User,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();

        $user = new User;

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->is_approved = false;

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'User created');
    }

    public function approve(User $user)
    {
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
        return view('users.create-or-edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $validated = $request->validated();

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->has('password') && $validated['password'] !== null) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', sprintf('User %s updated', $user->email));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', sprintf('User %s deleted', $user->email));
    }
}
