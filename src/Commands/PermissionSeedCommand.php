<?php

namespace Smoothsystem\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class PermissionSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed permission.';

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
            Artisan::call('db:seed', ['--class' => 'PermissionsTableSeeder']);
            $this->info('Successfully seed permissions.');
        } catch (\Exception $e) {
            $this->line($e->getMessage());

            return false;
        }
    }
}
