<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserIsApproved
{
    /**
     * Check if user is not deleted and is approved
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || $request->user()->trashed() || ! $request->user()->is_approved) {
            return redirect('not-approved');
        }

        return $next($request);
    }
}
