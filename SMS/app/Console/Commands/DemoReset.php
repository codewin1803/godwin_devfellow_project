<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DemoReset extends Command
{
    protected $signature = 'demo:reset';
    protected $description = 'Reset system to demo state';

    public function handle()
    {
        $this->info('Resetting demo environment...');

        $this->call('migrate:fresh', [
            '--seed' => true,
        ]);

        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('route:clear');

        $this->info('Demo reset complete.');
    }
}
