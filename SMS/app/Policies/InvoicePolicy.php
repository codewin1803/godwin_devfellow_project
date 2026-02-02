<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy
{
    /**
     * Determine whether the user can view invoices.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Bursar');
    }

    /**
     * Determine whether the user can view a specific invoice.
     */
    public function view(User $user, Invoice $invoice): bool
    {
        if ($user->hasRole('Bursar')) {
            return true;
        }

        if ($user->hasRole('Parent')) {
            return $invoice->student->parent_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can create invoices.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Bursar');
    }

    /**
     * Determine whether the user can update invoices.
     */
    public function update(User $user, Invoice $invoice): bool
    {
        return $user->hasRole('Bursar');
    }

    /**
     * Determine whether the user can delete invoices.
     */
    public function delete(User $user, Invoice $invoice): bool
    {
        return $user->hasRole('Bursar');
    }
}
