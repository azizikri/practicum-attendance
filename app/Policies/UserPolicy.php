<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\UserRole;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function isAdmin(User $user)
    {
        return $user->role == UserRole::Admin;
    }

    public function isAssistant(User $user)
    {
        return $user->role == UserRole::Assistant;
    }

    public function isStudent(User $user)
    {
        return $user->role == UserRole::Student;
    }
}
