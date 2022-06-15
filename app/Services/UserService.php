<?php

namespace App\Services;

use App\Exceptions\ModelCreateException;
use App\Models\Information;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        return User::create(Arr::only($data, [
            'name',
            'email',
            'password',
            'mobile',
            ]));
    }

    /**
     * @return mixed
     */
    public function getAllUsers(): mixed
    {
        return User::where('admin', 0)->paginate(20);
    }

    /**
     * @param $data
     * @return mixed
     * @throws Exception
     */
    public function createUserWithInformation($data): User
    {
        try {
            DB::beginTransaction();

            $user = $this->create($data);

            $user->information()->create(Arr::only($data,[
                'reference',
                'intake',
                'shift',
            ]));

            DB::commit();

            return $user;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    public function checkAdmin()
    {
        return Auth::user()->admin;
    }

    public function adminGetAllUser()
    {
        if($this->checkAdmin())
        {
            return $this->getAllUsers();
        }

        return null;
    }
}
