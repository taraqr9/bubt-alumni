<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        protected UserService $user,
    )
    {}
    public function index()
    {
        $checkAdmin = Auth::user()->admin;

        if($checkAdmin)
        {
            $users = $this->user->getAllUsers();
            return view('dashboard', compact('users'));
        }
        return view('dashboard');
    }
}
