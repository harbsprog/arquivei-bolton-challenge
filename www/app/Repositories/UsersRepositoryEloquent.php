<?php

namespace App\Repositories;

use App\User;
use App\Repositories\UsersRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersRepositoryEloquent implements UsersRepositoryInterface
{

    private $user;

    public function __construct(User $user)
    {

        $this->user = $user;
    }

    /**
     * Find all users.
     *
     * @param null
     *
     * @return mixed
     */
    public function getAll()
    {

        return $this->user
            ->select(
                'id',
                'email',
                'password'
            )->get();
    }

    /**
     * Find user by id.
     *
     * @param $id
     *
     * @return mixed
     */
    public function get(int $id)
    {

        return $this->user
            ->select(
                'id',
                'email',
                'password'
            )
            ->where('id', $id)
            ->get();
    }

    /**
     * Create & store new user.
     *
     * @param $request
     *
     * @return static
     */
    public function store(Request $request)
    {

        $request->merge([
            'password' => Hash::make($request->password)
        ]);
        return $this->user->create($request->all());
    }

    /**
     * Update user by id.
     *
     * @param $id
     * @param $request
     *
     * @return mixed
     */
    public function update(int $id, Request $request)
    {

        $request->merge([
            'password' => Hash::make($request->password)
        ]);
        return $this->user
            ->where('id', $id)
            ->update($request->all());
    }

    /**
     * Delete user by id.
     *
     * @param $id
     *
     * @return int
     */
    public function destroy(int $id)
    {

        $user = $this->user->find($id);
        return $user->delete();
    }
}
