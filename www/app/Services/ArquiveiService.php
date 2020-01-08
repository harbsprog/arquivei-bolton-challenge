<?php

namespace App\Services;

use App\Repositories\ArquiveiRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class ArquiveiService
{
    private $nfesRepository;
    const NOT_FOUND_NFE = 'NFe not found.';
    const NOT_CREATED_NFE = 'NFe not created.';
    const NOT_UPDATED_NFE = 'NFe not updated.';
    const NOT_DELETED_NFE = 'NFe not deleted.';
    const ERRO_MYSQL_CONNECTION = 'Erro de conexão com o banco.';

    public function __construct(NfesRepositoryInterface $nfesRepository)
    {

        $this->nfesRepository = $nfesRepository;
    }

    /**
     * Find a nfe by access_key.
     *
     * @param $access_key
     *
     * @return mixed
     */
    public function getByAccessKey(string $access_key)
    {

        try {

            $nfe = $this->nfesRepository->getByAccessKey($access_key);

            if ($nfe) {

                return response()->json($nfe, Response::HTTP_OK);
            }

            return response()->json(['message' => self::NOT_FOUND_NFE], Response::HTTP_OK);
        } catch (QueryException $e) {

            return response()->json(['erro' => self::ERRO_MYSQL_CONNECTION], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Find a nfe by id.
     *
     * @param $id
     *
     * @return mixed
     */
    public function get(int $id)
    {

        try {

            $nfe = $this->nfesRepository->get($id);

            if ($nfe) {

                return response()->json($nfe, Response::HTTP_OK);
            }

            return response()->json(['message' => self::NOT_FOUND_NFE], Response::HTTP_OK);
        } catch (QueryException $e) {

            return response()->json(['erro' => self::ERRO_MYSQL_CONNECTION], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create & Store a new nfe.
     *
     * @param $request
     *
     * @return static
     */
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            NfesValidator::NEW_PACKAGE_RULE,
            NfesValidator::ERROR_MESSAGES
        );

        if ($validator->fails()) {

            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {

            try {

                $nfe = $this->nfesRepository->store($request);

                if ($nfe) {
                    return response()->json($nfe, Response::HTTP_CREATED);
                }

                return response()->json(['message' => self::NOT_CREATED_NFE], Response::HTTP_OK);
            } catch (QueryException $e) {

                return response()->json(['erro' => self::ERRO_MYSQL_CONNECTION], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    /**
     * Update nfe by access_key.
     *
     * @param $access_key
     * @param $request
     *
     * @return int
     */
    public function update(string $access_key, Request $request)
    {

        try {

            $nfe = $this->nfesRepository->update($access_key, $request);

            if ($nfe) {
                return response()->json($nfe, Response::HTTP_OK);
            }

            return response()->json(['message' => self::NOT_UPDATED_NFE], Response::HTTP_OK);
        } catch (QueryException $e) {

            return response()->json(['erro' => self::ERRO_MYSQL_CONNECTION], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Delete nfe by access_key.
     *
     * @param $access_key
     *
     * @return int
     */
    public function destroy(string $access_key)
    {

        try {

            $nfe = $this->nfesRepository->destroy($access_key);

            if ($nfe) {
                return response()->json($nfe, Response::HTTP_OK);
            }

            return response()->json(['message' => self::NOT_DELETED_NFE], Response::HTTP_OK);
        } catch (QueryException $e) {

            return response()->json(['erro' => self::ERRO_MYSQL_CONNECTION], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
