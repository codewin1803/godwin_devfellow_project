<?php

namespace App\Providers;

use App\Models\School;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Announcement;
use App\Policies\SchoolPolicy;
use App\Policies\AttendancePolicy;
use App\Policies\GradePolicy;
use App\Policies\InvoicePolicy;
use App\Policies\PaymentPolicy;
use App\Policies\AnnouncementPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        School::class       => SchoolPolicy::class,
        Attendance::class   => AttendancePolicy::class,
        Grade::class        => GradePolicy::class,
        Invoice::class      => InvoicePolicy::class,
        Payment::class      => PaymentPolicy::class,
        Announcement::class => AnnouncementPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
