<?php

use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes & Scheduled Tasks
|--------------------------------------------------------------------------
|
| This file is used in Laravel 11 to define scheduled commands
| and console-only routes.
|
| Day 25: Backups & Maintenance
|
*/

// 🔁 Daily full system backup (database + files)
Schedule::command('backup:run')
    ->dailyAt('01:00')
    ->description('Run daily system backup');

// 🧹 Cleanup old backups based on retention policy
Schedule::command('backup:clean')
    ->dailyAt('02:00')
    ->description('Clean up old backups');
