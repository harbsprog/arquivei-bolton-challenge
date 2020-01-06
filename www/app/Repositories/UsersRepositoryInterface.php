<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface UsersRepositoryInterface
{
    public function getAll();
    public function get(int $id);
    public function store(Request $request);
    public function update(int $id, Request $request);
    public function destroy(int $id);
}
