<?php

namespace App\Http\Controllers;

use App\Exceptions\ModelCreateException;
use App\Services\AuthService;
use App\Services\UserService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('login');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function register(Request $request): RedirectResponse
    {


        try{
            $data = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'mobile' => 'required|integer',
                'intake' => 'required|integer',
                'shift' => 'required',
                'university_id' => 'nullable',
                'passing_year' => 'nullable|date',
                'current_job_designation' => 'nullable|string',
                'current_company' => 'nullable|string',
                'lives' => 'nullable|string',
                'reference' => 'required|email|exists:users,email',
            ]);

            $user = $this->user->createUserWithInformation($data);
            auth()->login($user, true);
            return redirect()->route('dashboard')->with([
                'success' => 'User registered successfully!'
            ]);
        }catch(Exception $exception){
            return redirect()->back()->with([
                'error' => $exception->getMessage() ?: 'Unable to register user!'
            ]);
        }
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
        Auth::logout();

        return redirect()->route('login');
    }

    /**
     * @return Application|Factory|View
     */
    public function profile(): View|Factory|Application
    {
        $user = Auth::user();

        return view('profile', compact('user'));
    }


}
