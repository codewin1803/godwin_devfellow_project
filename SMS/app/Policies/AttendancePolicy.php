<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;

class AttendancePolicy
{
    /**
     * Determine whether the user can view attendance records.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['Teacher', 'SchoolAdmin']);
    }

    /**
     * Determine whether the user can view a specific attendance record.
     */
    public function view(User $user, Attendance $attendance): bool
    {
        return $user->hasRole(['Teacher', 'SchoolAdmin'])
            && $attendance->school_id === $user->school_id;
    }

    /**
     * Determine whether the user can create attendance.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Teacher');
    }

    /**
     * Determine whether the user can update attendance.
     */
    public function update(User $user, Attendance $attendance): bool
    {
        return $user->hasRole('Teacher')
            && $attendance->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can delete attendance.
     */
    public function delete(User $user, Attendance $attendance): bool
    {
        return $user->hasRole('SchoolAdmin');
    }
}
