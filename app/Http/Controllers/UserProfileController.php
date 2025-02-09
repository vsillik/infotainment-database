<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfilePasswordRequest;
use App\Http\Requests\UserProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    /**
     * Show form for editing the current user
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'breadcrumbs' => [
                route('index') => 'Home',
                'current' => 'Profile settings',
            ],
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the current user
     */
    public function update(UserProfileRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        $user->name = $validated['name'];

        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profile updated');
    }

    /**
     * Show password for changing password of current user
     */
    public function editPassword(): View
    {
        return view('profile.password.edit', [
            'breadcrumbs' => [
                route('index') => 'Home',
                route('profile.edit') => 'Profile settings',
                'current' => 'Change password',
            ],
        ]);
    }

    /**
     * Update password of current user
     */
    public function updatePassword(UserProfilePasswordRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        $user->password = Hash::make($validated['password']);

        $user->save();

        return redirect()
            ->route('profile.password.edit')
            ->with('success', 'Password updated');
    }
}
