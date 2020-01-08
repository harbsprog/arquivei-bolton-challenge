<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UsersService;

class UsersController extends Controller
{

    private $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
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
        return $this->usersService->getAll();
    }

    /**
     * Find a user by id.
     *
     * @param $id
     *
     * @return mixed
     */
    public function get(int $id)
    {
        return $this->usersService->get($id);
    }

    /**
     * Create & Store new user.
     *
     * @param $request
     *
     * @return static
     */
    public function store(Request $request)
    {
        return $this->usersService->store($request);
    }

    /**
     * Update a user by id.
     *
     * @param $id
     * @param $request
     *
     * @return mixed
     */
    public function update(int $id, Request $request)
    {
        return $this->usersService->update($id, $request);
    }

    /**
     * Delete a user by id.
     *
     * @param $id
     *
     * @return int
     */
    public function destroy(int $id)
    {
        return $this->usersService->destroy($id);
    }
}
