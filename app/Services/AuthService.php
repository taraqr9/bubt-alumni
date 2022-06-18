<?php

namespace App\Services;

use App\Exceptions\ModelCreateException;
use App\Models\User;
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
     * @param $data
     * @return User|null
     * @throws ModelCreateException]
     */
    public function login($data): User|null
    {
        $user = $this->user->findWithEmail($data['email']);

        if (!Hash::check($data['password'], $user->password)) return null;

        return $user;
    }
}
