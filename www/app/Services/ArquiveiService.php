<?php

namespace App\Services;

use App\Repositories\ArquiveiRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class ArquiveiService
{
    private $arquiveiRepository;
    const NOT_FOUND_NFE = 'Nfe not found, we will capture, try again in a few moments.';
    const ERRO_MYSQL_CONNECTION = 'Erro de conexão com o banco.';

    public function __construct(ArquiveiRepositoryInterface $arquiveiRepository)
    {

        $this->arquiveiRepository = $arquiveiRepository;
    }

    /**
     * Find a nfe by access_key.
     *
     * @param $access_key
     *
     * @return mixed
     */
    public function getByAccessKey(string $access_key, Request $request)
    {

        try {

            $nfe = $this->arquiveiRepository->findByAccessKey($access_key, $request);

            if ($nfe) {

                return response()->json($nfe, Response::HTTP_OK);
            }

            return response()->json(['message' => self::NOT_FOUND_NFE], Response::HTTP_OK);
        } catch (QueryException $e) {

            return response()->json(['erro' => self::ERRO_MYSQL_CONNECTION], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
