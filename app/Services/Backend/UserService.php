<?php

namespace App\Services\Backend;

use App\Models\User;
use Illuminate\Support\Collection;

class UserService
{
    public function all(): Collection
    {
        return User::select('id', 'name', 'email', 'phone', 'status', 'created_at')->get();
    }
}
