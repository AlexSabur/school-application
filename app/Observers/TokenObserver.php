<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;

class TokenObserver
{
    public function creating(User $user)
    {
        $user->application_token = (string) Str::uuid();
    }
}
