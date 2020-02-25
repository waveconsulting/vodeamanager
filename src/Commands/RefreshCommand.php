<?php

namespace Smoothsystem\Core\Commands;

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
    protected $signature = 'refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh all database.';

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
            Artisan::call('migrate:fresh');
            $this->info('Successfully migrate.');
        } catch (\Exception $e) {
            $this->line($e->getMessage());

            return false;
        }

        try {
            Artisan::call('db:seed');
            $this->info('Successfully seed.');
        } catch (\Exception $e) {
            $this->line($e->getMessage());

            return false;
        }

        if (config('smoothsystem.passport.register')) {
            try {
                Artisan::call('passport:install');

                DB::table('oauth_clients')->where('id', 2)
                    ->update([
                        'secret' => 'ol9FSJh3ypk4FdYUu2pL0wp21UransnXSKi5DaGm'
                    ]);

                $this->info('Successfully passport install.');
            } catch (\Exception $e) {
                $this->line($e->getMessage());

                return false;
            }
        }

        return true;
    }
}