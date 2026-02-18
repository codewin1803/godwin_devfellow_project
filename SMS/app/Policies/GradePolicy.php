<?php

namespace App\Policies;

use App\Models\Grade;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GradePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Teachers and Admins can see lists of grades.
        return $user->hasAnyRole(['SchoolAdmin', 'Teacher']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Grade $grade): bool
    {
        // Admins, Teachers, Students, and Parents should be able to view grades.
        // More specific logic based on relationships would be ideal here.
        return $user->hasAnyRole(['SchoolAdmin', 'Teacher', 'Student', 'Parent']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Teacher');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Grade $grade): bool
    {
        return $user->hasRole('Teacher');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Grade $grade): bool
    {
        return $user->hasRole('SchoolAdmin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Grade $grade): bool
    {
        return $user->hasRole('SchoolAdmin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Grade $grade): bool
    {
        return $user->hasRole('SchoolAdmin');
    }
}
