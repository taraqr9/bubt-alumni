<?php

namespace App\Http\Controllers;

use App\Exceptions\ModelCreateException;
use App\Models\User;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $auth,
        protected UserService $user,
    )
    {}

    /**
     * @return Factory|View|Application
     */
    public function loginPage(): Factory|View|Application
    {
        if(Auth::user())
        {
            return view('dashboard');
        }

        return view('login');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ModelCreateException
     */
    public function register(Request $request): RedirectResponse
    {
        $user = $this->auth->register($request);
        auth()->login($user);
        return redirect()->route('dashboard');
    }

    /**
     * @param Request $request
     * @return View|Factory|Application
     * @throws ModelCreateException
     */
    public function login(Request $request): View|Factory|Application
    {
        $user = $this->auth->login(... $request->only(['email', 'password']));
        auth()->login($user);
        return view('dashboard');
    }

    /**
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::guard('auth')->logout();

        return redirect()->route('login');
    }


}
