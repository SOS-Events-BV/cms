<?php

namespace SOSEventsBV\Cms\Policies;

use App\Models\User;

class ProductPolicy
{
    public function delete(User $user)
    {
        return $user->hasRole('admin');
    }
}
