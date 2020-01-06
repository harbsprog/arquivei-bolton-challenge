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
    const ERRO_MYSQL_CONNECTION = 'Erro de conexão com o banco';

    public function __construct(UsersRepositoryInterface $usersRepository)
    {

        $this->usersRepository = $usersRepository;
    }

    public function getAll()
    {

        try {

            $users = $this->usersRepository->getAll();
            $countItems = (count($users) > 0) ? true : false;

            if ($countItems) {

                return response()->json($users, Response::HTTP_OK);
            } else {

                return response()->json([], Response::HTTP_OK);
            }
        } catch (QueryException $e) {

            return response()->json(['erro' => self::ERRO_MYSQL_CONNECTION], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get(int $id)
    {

        try {

            $user = $this->usersRepository->get($id);
            $countItems = (count($user) > 0) ? true : false;

            if ($countItems) {

                return response()->json($user, Response::HTTP_OK);
            } else {

                return response()->json(null, Response::HTTP_NOT_FOUND);
            }
        } catch (QueryException $e) {

            return response()->json(['erro' => self::ERRO_MYSQL_CONNECTION], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

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
                return response()->json($user, Response::HTTP_CREATED);
            } catch (QueryException $e) {

                return response()->json(['erro' => self::ERRO_MYSQL_CONNECTION], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function update(int $id, Request $request)
    {

        try {

            $user = $this->usersRepository->update($id, $request);
            return response()->json($user, Response::HTTP_OK);
        } catch (QueryException $e) {

            return response()->json(['erro' => self::ERRO_MYSQL_CONNECTION], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $id)
    {

        try {

            $user = $this->usersRepository->destroy($id);
            return response()->json($user, Response::HTTP_OK);
        } catch (QueryException $e) {

            return response()->json(['erro' => self::ERRO_MYSQL_CONNECTION], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
