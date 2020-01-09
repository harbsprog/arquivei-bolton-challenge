<?php

namespace App\Http\Controllers\Nfes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NfesService;


class NfeController extends Controller
{
    private $nfesService;

    public function __construct(NfesService $nfesService)
    {
        $this->nfesService = $nfesService;
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
        return $this->nfesService->getByAccessKey($access_key);
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
        return $this->nfesService->get($id);
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
        return $this->nfesService->store($request);
    }

    /**
     * Update nfe by access_key.
     *
     * @param $access_key
     *
     * @return int
     */
    public function update(string $access_key, Request $request)
    {
        return $this->nfesService->update($access_key, $request);
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
        return $this->nfesService->destroy($access_key);
    }
}
