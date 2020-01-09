<?php

namespace App\Http\Controllers\Arquivei;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ArquiveiService;

class ArquiveiController extends Controller
{
    private $arquiveiService;

    public function __construct(ArquiveiService $arquiveiService)
    {
        $this->arquiveiService = $arquiveiService;
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
        return $this->arquiveiService->getByAccessKey($access_key, $request);
    }
}
