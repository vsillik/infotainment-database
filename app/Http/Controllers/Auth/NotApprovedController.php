<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotApprovedController extends Controller
{
    /**
     * Show that the User is deleted or not approved
     */
    public function show(Request $request): RedirectResponse|Response
    {
        if ($request->user() && ! $request->user()->trashed() && $request->user()->is_approved) {
            return redirect()->route('index');
        }

        return response()->view('auth.not-approved', [
            'user' => $request->user(),
        ], status: 403);
    }
}
