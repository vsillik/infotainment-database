<?php

namespace App\Http\Controllers;

use App\Models\Infotainment;
use App\Models\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function index(Request $request): View
    {
        $userRole = $request->user()->role;

        if ($userRole === UserRole::CUSTOMER) {
            return view('home.customer', [
                'breadcrumbs' => []
            ]);
        }

        if ($userRole === UserRole::OPERATOR) {
            return view('home.operator', [
                'breadcrumbs' => []
            ]);
        }

        $infotainments = Infotainment::whereRelation('profiles', 'is_approved', false)->get();

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
