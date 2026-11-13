<?php

namespace SOSEventsBV\Cms\Policies;

use App\Models\User;

class PagePolicy
{
    public function delete(User $user)
    {
        return $user->hasRole('admin');
    }
}
