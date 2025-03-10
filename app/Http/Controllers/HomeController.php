<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Infotainment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show homepage based on user role
     */
    public function index(Request $request): View
    {
        /** @var User $user because user must be logged in, this won't be null */
        $user = $request->user();
        $userRole = $user->role;

        if ($userRole === UserRole::CUSTOMER) {
            return view('home.customer', [
                'breadcrumbs' => [],
            ]);
        }

        if ($userRole === UserRole::OPERATOR) {
            return view('home.operator', [
                'breadcrumbs' => [],
            ]);
        }

        $infotainments = Infotainment::whereRelation('profiles', 'is_approved', false)
            ->with([
                'infotainmentManufacturer',
                'serializerManufacturer',
            ])
            ->get();

        if ($userRole === UserRole::VALIDATOR) {
            return view('home.validator-administrator', [
                'breadcrumbs' => [],
                'userRole' => $userRole,
                'infotainments' => $infotainments,
                'users' => [],
            ]);
        }

        $users = User::where('is_approved', false)->get();

        return view('home.validator-administrator', [
            'breadcrumbs' => [],
            'userRole' => $userRole,
            'infotainments' => $infotainments,
            'users' => $users,
        ]);
    }
}
