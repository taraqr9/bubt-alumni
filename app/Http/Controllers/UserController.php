<?php

namespace App\Http\Controllers;

use App\Exceptions\ModelCreateException;
use App\Models\User;
use App\Services\AuthService;
use App\Services\UserService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function __construct(
        protected UserService $user,
    )
    {}

    /**
     * @param $email
     * @return Factory|View|Application
     * @throws ModelCreateException
     */
    public function getUserProfile($email): Factory|View|Application
    {
        $user = $this->user->findWithEmail($email);
        return view('user.profile', compact('user'));
    }


}
