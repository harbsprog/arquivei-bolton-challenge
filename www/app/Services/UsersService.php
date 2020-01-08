<?php

namespace App\Services;

use App\Repositories\UsersRepositoryInterface;
use App\Models\UsersValidator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class UsersService
{
    private $usersRepository;
    const NOT_FOUND_USER = 'User not found.';
    const NOT_CREATED_USER = 'User not created.';
    const NOT_UPDATED_USER = 'User not updated.';
    const NOT_DELETED_USER = 'User not deleted.';
    const ERRO_MYSQL_CONNECTION = 'Erro de conexão com o banco.';

    public function __construct(UsersRepositoryInterface $usersRepository)
    {

        $this->usersRepository = $usersRepository;
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

        try {

            $users = $this->usersRepository->getAll();

            if ($users) {

                return response()->json($users, Response::HTTP_OK);
            }

            return response()->json(['message' => self::NOT_FOUND_USER], Response::HTTP_OK);
        } catch (QueryException $e) {

            return response()->json(['erro' => self::ERRO_MYSQL_CONNECTION], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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

        try {

            $user = $this->usersRepository->get($id);

            if ($user) {

                return response()->json($user, Response::HTTP_OK);
            }

            return response()->json(['message' => self::NOT_FOUND_USER], Response::HTTP_OK);
        } catch (QueryException $e) {

            return response()->json(['erro' => self::ERRO_MYSQL_CONNECTION], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create & Store a new user.
     *
     * @param $request
     *
     * @return static
     */
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            UsersValidator::NEW_PACKAGE_RULE,
            UsersValidator::ERROR_MESSAGES
        );

        if ($validator->fails()) {

            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {

            try {

                $user = $this->usersRepository->store($request);

                if ($user) {

                    return response()->json($user, Response::HTTP_CREATED);
                }

                return response()->json(['message' => self::NOT_CREATED_USER], Response::HTTP_OK);
            } catch (QueryException $e) {

                return response()->json(['erro' => self::ERRO_MYSQL_CONNECTION], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
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

        try {

            $user = $this->usersRepository->update($id, $request);

            if ($user) {

                return response()->json($user, Response::HTTP_OK);
            }

            return response()->json(['message' => self::NOT_UPDATED_USER], Response::HTTP_OK);
        } catch (QueryException $e) {

            return response()->json(['erro' => self::ERRO_MYSQL_CONNECTION], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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

        try {

            $user = $this->usersRepository->destroy($id);

            if ($user) {

                return response()->json($user, Response::HTTP_OK);
            }

            return response()->json(['message' => self::NOT_DELETED_USER], Response::HTTP_OK);
        } catch (QueryException $e) {

            return response()->json(['erro' => self::ERRO_MYSQL_CONNECTION], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
