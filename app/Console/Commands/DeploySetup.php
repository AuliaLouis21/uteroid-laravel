<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class DeploySetup extends Command
{
    protected $signature = 'deploy:setup';
    protected $description = 'Run all production setup tasks';

    public function handle(): int
    {
        $this->info('=== PRODUCTION DEPLOYMENT SETUP ===');
        $this->newLine();

        // 1. Check .env
        $this->info('[1/6] Checking .env configuration...');
        if (env('APP_DEBUG') !== false) {
            $this->warn('  WARNING: APP_DEBUG is not set to false!');
            $this->warn('  Copy .env.production to .env and update credentials.');
            $this->newLine();
        } else {
            $this->info('  APP_DEBUG=false ✓');
        }

        // 2. Storage link
        $this->info('[2/6] Creating storage symlink...');
        Artisan::call('storage:link', ['--force' => true]);
        $this->info('  ' . Artisan::output());

        // 3. Run migrations
        $this->info('[3/6] Running migrations...');
        $exitCode = Artisan::call('migrate', ['--force' => true]);
        if ($exitCode !== 0) {
            $this->error('  Migration failed! Check database connection.');
            return 1;
        }
        $this->info('  ' . Artisan::output());

        // 4. Cache config
        $this->info('[4/6] Caching configuration...');
        Artisan::call('config:cache');
        $this->info('  ' . Artisan::output());

        // 5. Cache routes & views
        $this->info('[5/6] Caching routes and views...');
        Artisan::call('route:cache');
        Artisan::call('view:cache');
        $this->info('  ' . Artisan::output());

        // 6. Optimize
        $this->info('[6/6] Running optimize...');
        Artisan::call('optimize');
        $this->info('  ' . Artisan::output());

        $this->newLine();
        $this->info('=== DEPLOYMENT SETUP COMPLETE ===');
        $this->newLine();
        $this->warn('Next steps:');
        $this->line('  1. Run: php artisan import:legacy --truncate  (if migrating from legacy DB)');
        $this->line('  2. Run: php artisan db:seed  (for default data)');
        $this->line('  3. Test all features in production');
        $this->line('  4. Monitor storage/logs/laravel.log for 48 hours');

        return 0;
    }
}
