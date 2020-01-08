<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface NfesRepositoryInterface
{
    public function getByAccessKey(string $access_key);
    public function get(int $id);
    public function store(array $array);
    public function update(int $access_key, Request $request);
    public function destroy(int $access_key);
}
