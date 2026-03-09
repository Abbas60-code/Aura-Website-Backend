<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Run migrations with retries (for unstable connections e.g. Railway from local)
Artisan::command('migrate:retry {--attempts=5 : Number of attempts} {--delay=3 : Seconds between attempts}', function () {
    $attempts = (int) $this->option('attempts');
    $delay = (int) $this->option('delay');

    for ($i = 1; $i <= $attempts; $i++) {
        $this->info("Migration attempt {$i}/{$attempts}...");
        try {
            DB::purge(); // force fresh connection
            $this->call('migrate');
            $this->info('Migrations completed.');
            return 0;
        } catch (\Throwable $e) {
            $msg = $e->getMessage();
            $isGoneAway = str_contains($msg, 'MySQL server has gone away')
                || str_contains($msg, 'greeting packet')
                || str_contains($msg, 'Error while reading');
            if (!$isGoneAway || $i === $attempts) {
                throw $e;
            }
            $this->warn('Connection failed. Retrying in ' . $delay . 's...');
            sleep($delay);
        }
    }
})->purpose('Run migrations with retries for unstable DB connections (e.g. Railway)');
