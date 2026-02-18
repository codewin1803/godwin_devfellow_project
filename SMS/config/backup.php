<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Backup Name
    |--------------------------------------------------------------------------
    */
    'backup' => [

        'name' => env('APP_NAME', 'sms'),

        /*
        |--------------------------------------------------------------------------
        | Backup Source
        |--------------------------------------------------------------------------
        */
        'source' => [

            'files' => [
                'include' => [
                    base_path(),
                ],

                'exclude' => [
                    base_path('vendor'),
                    base_path('node_modules'),
                    base_path('storage/logs'),
                ],
            ],

            'databases' => [
                'mysql',
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Backup Destination
        |--------------------------------------------------------------------------
        */
        'destination' => [
            'filename_prefix' => '',
            'disks' => [
                'local',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */
    'notifications' => [

        'notifications' => [
            \Spatie\Backup\Notifications\Notifications\BackupHasFailed::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\UnhealthyBackupWasFound::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\CleanupHasFailed::class => ['mail'],
        ],

        'notifiable' => \Spatie\Backup\Notifications\Notifiable::class,

        'mail' => [
            'to' => env('ADMIN_EMAIL', 'admin@sms.com'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cleanup Strategy
    |--------------------------------------------------------------------------
    */
    'cleanup' => [
        'strategy' => \Spatie\Backup\Tasks\Cleanup\Strategies\DefaultStrategy::class,

        'default_strategy' => [
            'keep_all_backups_for_days' => 7,
            'keep_daily_backups_for_days' => 16,
            'keep_weekly_backups_for_weeks' => 8,
            'keep_monthly_backups_for_months' => 4,
            'keep_yearly_backups_for_years' => 2,
            'delete_oldest_backups_when_using_more_megabytes_than' => 5000,
        ],
    ],
];
