<?php

namespace App\Http\Controllers\Nfes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NfesService;


class NfeController extends Controller
{
    private $NfesService;

    public function __construct(NfesService $NfesService)
    {
        $this->NfesService = $NfesService;
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
        return $this->NfesService->getByAccessKey($access_key);
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
        return $this->NfesService->get($id);
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
        return $this->NfesService->store($request);
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
        return $this->NfesService->update($access_key, $request);
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
        return $this->NfesService->destroy($access_key);
    }
}
