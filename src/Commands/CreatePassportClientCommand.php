<?php

namespace Vodeamanager\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class CreatePassportClientCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:passport:client';

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
            Artisan::call('passport:keys');

            Artisan::call('passport:install');

            DB::table('oauth_clients')->where('id', 2)
                ->update([
                    'secret' => 'ol9FSJh3ypk4FdYUu2pL0wp21UransnXSKi5DaGm'
                ]);

            Artisan::call('passport:client', ['--client' => true, '--name' => config('app.name') . ' Clients']);

            DB::table('oauth_clients')->where('id', 3)
                ->update([
                    'secret' => '1Vtcaz199fPLMBS4CXoTor8FaoGZWo2boAWKQGCd'
                ]);

            $this->info('Successfully passport install.');
        } catch (\Exception $e) {
            $this->line($e->getMessage());

            return;
        }
    }
}
