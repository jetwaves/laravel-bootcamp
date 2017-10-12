<?php

namespace Jetwaves\LaravelBootcamp\Commands;

use Illuminate\Console\Command;

class LaravelBootcampInitConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bootcamp:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Prepare a laravel API project \r\n\t\t\t 1. route-to-controller integration \r\n\t\t\t 2. Tymon/JWTAuth file publication \r\n\t\t\t 3. xxx  ";

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
        //
    }
}
