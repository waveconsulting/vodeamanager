<?php

namespace Vodeamanager\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

// todo: create entity command
class CreateEntityCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:entity {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create entity.';

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
        $name = $this->argument('name');

        Artisan::call('make:model Entities/' . $name);
        Artisan::call('make:controller ' . $name . 'Controller');
        Artisan::call('make:request ' . $name . 'CreateRequest');
        Artisan::call('make:request ' . $name . 'UpdateRequest');
        Artisan::call('make:resource ' . $name . 'Resource');

        return true;
    }
}
