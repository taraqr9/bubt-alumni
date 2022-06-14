<?php

namespace App\Services;

use App\Exceptions\ModelCreateException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService extends Service
{
    public function __construct(
        protected UserService $user,
    ){}
    /**
     * @param $id
     * @return User
     */
    public function find($id): User
    {
        return User::find($id)->get();
    }

    /**
     * @param Request $request
     * @return User
     */
    public function register(Request $request): User
    {

        return $this->user->create($request->only([
            'name',
            'email',
            'password',
            'mobile'
        ]));
    }

    /**
     * @param string $email
     * @param string $password
     * @return User|null
     * @throws ModelCreateException
     */
    public function login(string $email, string $password): ?User
    {
        $user = $this->user->findWithEmail($email);

        if (!Hash::check($password, $user->password)) return null;

        return $user;
    }
}
