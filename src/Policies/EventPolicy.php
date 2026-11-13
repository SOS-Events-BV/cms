<?php

namespace SOSEventsBV\Cms\Policies;

use App\Models\User;

class EventPolicy
{
    public function delete(User $user)
    {
        return $user->hasRole('admin');
    }
}
