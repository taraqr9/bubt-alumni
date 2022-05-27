<?php

namespace App\Services;

use App\Exceptions\ModelCreateException;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService extends Service
{
    /**
     * @param $id
     * @return User
     */
    public function find($id): User
    {
        return User::find($id);
    }

    /**
     * @param $email
     * @return User
     * @throws ModelCreateException
     */
    public function findWithEmail($email): User
    {
        $user = User::where('email', $email)
            ->first();

        if (blank($user)) {
            throw new ModelnotFoundException();
        }

        return $user;
    }

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * @return mixed
     */
    public function getAllUsers(): mixed
    {
        return User::where('admin', 0)->get();
    }
}
