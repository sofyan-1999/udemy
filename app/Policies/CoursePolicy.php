<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    // Admin
    public function viewAnyAsAdmin(?User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function createAsAdmin(?User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function updateAsAdmin(?User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function deleteAsAdmin(?User $user): bool
    {
        return $user->hasRole('admin');
    }

    // Student
    public function viewAnyAsStudent(?User $user): bool
    {
        return $user->role === 'student';
    }

    public function viewAsStudent(?User $user): bool
    {
        return $user->hasRole('student');
    }
}
