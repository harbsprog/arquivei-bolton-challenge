<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface NfesRepositoryInterface
{
    public function getByAccessKey(string $access_key);
    public function get(int $id);
    public function store(Object $obj);
    public function update(string $access_key, Request $request);
    public function destroy(string $access_key);
}
