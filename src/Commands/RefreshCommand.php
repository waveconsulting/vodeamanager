<?php

namespace Vodeamanager\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class RefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manager:refresh
                   {--force : force refresh.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh all database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            Artisan::call('migrate:fresh', ['--force' => $this->option('force')]);
            $this->info('Successfully migrate.');
        } catch (\Exception $e) {
            $this->line($e->getMessage());

            return;
        }

        try {
            Artisan::call('db:seed', ['--force' => $this->option('force')]);
            $this->info('Successfully seed.');
        } catch (\Exception $e) {
            $this->line($e->getMessage());

            return;
        }

        if (config('vodeamanager.passport.register', true)) {
            try {
                Artisan::call('manager:passport');
                $this->info('Successfully passport install.');
            } catch (\Exception $e) {
                $this->line($e->getMessage());

                return;
            }
        }
    }

}
