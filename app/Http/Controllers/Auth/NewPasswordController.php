<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\NewPasswordRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset form
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', [
            'token' => $request->route('token'),
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Handle an incoming new password request.
     */
    public function store(NewPasswordRequest $request): RedirectResponse
    {
        /** @var array{token: string, email: string, password: string} $validated */
        $validated = $request->validated();

        $status = Password::reset(
            $validated,
            function (User $user) use ($validated) {
                $user->password = Hash::make($validated['password']);
                // we also should reset the remember token
                $user->remember_token = null;
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect(route('login'))
                ->with('success', 'Password reset successfully');
        }

        return redirect()
            ->back()
            ->withInput($request->only('email'))
            ->with('error', match ($status) {
                Password::INVALID_USER => 'User with specified token and email could not be found',
                Password::INVALID_TOKEN => 'The reset token is invalid',
                default => 'Something went wrong, please try again',
            });
    }
}
