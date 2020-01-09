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
                'total_value',
                'xml_content'
            )->where('access_key', $access_key)
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
     * Delete a nfe by access_key.
     *
     * @param $access_key
     *
     * @return int
     */
    public function destroy(string $access_key)
    {

        $nfe = $this->nfe->where('access_key', $access_key);
        return $nfe->delete();
    }
}
