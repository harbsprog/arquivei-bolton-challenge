<?php

namespace App\Repositories;

interface ArquiveiRepositoryInterface
{
    public function getPriceOnXml(string $xml);
    public function get(string $status, string $urlCursor = null);
    public function findByAccessKey(string $access_key);
}
