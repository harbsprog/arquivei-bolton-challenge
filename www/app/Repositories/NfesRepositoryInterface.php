<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface NfesRepositoryInterface
{
    public function getByAccessKey(string $access_key);
    public function store(Object $obj);
    public function destroy(string $access_key);
}
