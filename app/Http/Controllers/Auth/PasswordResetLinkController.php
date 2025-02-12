<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetLinkRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     */
    public function store(PasswordResetLinkRequest $request): RedirectResponse
    {
        /** @var array{email: string} $validated */
        $validated = $request->validated();

        $status = Password::sendResetLink($validated);

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Password reset link sent.');
        }

        return redirect()
            ->back()
            ->withInput($request->only('email'))
            ->with('error', match ($status) {
                Password::INVALID_USER => 'The user does not exist',
                Password::PASSWORD_RESET => 'The password reset token is invalid',
                Password::RESET_THROTTLED => 'Too many requests, please wait before retrying',
                default => 'Something went wrong, please try again'
            });
    }
}
