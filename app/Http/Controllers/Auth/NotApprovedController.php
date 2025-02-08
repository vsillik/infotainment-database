<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotApprovedController extends Controller
{
    public function show(Request $request)
    {
        if ($request->user() && ! $request->user()->trashed() && $request->user()->is_approved) {
            return redirect()->route('index');
        }

        return response()->view('auth.not-approved', [
            'user' => $request->user(),
        ], status: 403);
    }
}
