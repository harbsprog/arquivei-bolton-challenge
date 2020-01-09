<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface ArquiveiRepositoryInterface
{
    public function getPriceOnXml(string $xml);
    public function get(string $status, string $urlCursor = null);
    public function setclient();
    public function findByAccessKey(string $access_key, Request $request);
}
