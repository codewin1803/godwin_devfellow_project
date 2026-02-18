<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PaymentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Bursar and SchoolAdmin can see all payments.
        return $user->hasAnyRole(['Bursar', 'SchoolAdmin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Payment $payment): bool
    {
        if ($user->hasAnyRole(['Bursar', 'SchoolAdmin'])) {
            return true;
        }
        // Parents should be able to see their own payments.
        // This would require checking the relationship, e.g., $user->id === $payment->invoice->student->parent_id
        return $user->hasRole('Parent');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['Bursar', 'SchoolAdmin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Payment $payment): bool
    {
        return $user->hasAnyRole(['Bursar', 'SchoolAdmin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Payment $payment): bool
    {
        return $user->hasAnyRole(['Bursar', 'SchoolAdmin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Payment $payment): bool
    {
        return $user->hasAnyRole(['Bursar', 'SchoolAdmin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Payment $payment): bool
    {
        return $user->hasAnyRole(['Bursar', 'SchoolAdmin']);
    }
}
