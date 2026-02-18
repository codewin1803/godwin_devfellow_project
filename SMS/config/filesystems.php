<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | For Day 25 (Backups & Maintenance), the local disk is used
    | for secure, non-public storage of backups and application files.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        /*
        |--------------------------------------------------------------------------
        | Local Disk (PRIMARY — DAY 25)
        |--------------------------------------------------------------------------
        |
        | Used by Spatie Backup to store:
        | - Database dumps
        | - Application snapshots
        |
        | This disk is PRIVATE and not web-accessible.
        |
        */
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
            'report' => false,
        ],

        /*
        |--------------------------------------------------------------------------
        | Public Disk
        |--------------------------------------------------------------------------
        |
        | Used only for publicly accessible assets (images, uploads).
        |
        */
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        /*
        |--------------------------------------------------------------------------
        | Amazon S3 (Optional — Production Backups)
        |--------------------------------------------------------------------------
        |
        | Can be enabled later for off-site backup storage.
        |
        */
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | These links are created when running:
    | php artisan storage:link
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
