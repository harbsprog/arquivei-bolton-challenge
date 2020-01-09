<?php

namespace App\Repositories;

use App\Models\Nfe;
use App\Repositories\NfesRepositoryInterface;
use Illuminate\Http\Request;

class NfesRepositoryEloquent implements NfesRepositoryInterface
{

    private $nfe;

    public function __construct(Nfe $nfe)
    {

        $this->nfe = $nfe;
    }

    /**
     * Find a nfe by access key.
     *
     * @param $access_key
     *
     * @return mixed
     */
    public function getByAccessKey(string $access_key)
    {

        return $this->nfe
            ->select(
                'access_key',
                'xml_content',
                'total_value'
            )->where('access_key', $access_key)
            ->get();
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

        return $this->nfe
            ->select(
                'access_key',
                'xml_content',
                'total_value'
            )
            ->where('id', $id)
            ->get();
    }

    /**
     * Create a new nfe.
     *
     * @param $array
     *
     * @return static
     */
    public function store(Object $obj)
    {

        if ($this->getByAccessKey($obj->nfeParsed->access_key)->count() == 0) {

            $this->nfe->create((array) $obj->nfeParsed);
        }
    }

    /**
     * Update a nfe by access_key.
     *
     * @param $access_key
     * @param $request
     *
     * @return mixed
     */
    public function update(string $access_key, Request $request)
    {

        return 'Not implemented';
    }

    /**
     * Delete a nfe by access_key.
     *
     * @param $access_key
     *
     * @return int
     */
    public function destroy(string $access_key)
    {

        $nfe = $this->nfe->find($access_key);
        return $nfe->delete();
    }
}
