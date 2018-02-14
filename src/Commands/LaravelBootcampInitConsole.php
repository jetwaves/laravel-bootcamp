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
    protected $description = "Prepare a laravel 5.5 API project \r\n\t\t\t 1. laravel-implicit-router integration \r\n\t\t\t 2. Tymon/JWTAuth integration \r\n\t\t\t ";

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
     *  "php artisan bootcamp:init "  command is handled here
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('STEP 1:  Installing jetwaves/laravel-implicit-router to enable Implicit Router ');
        exec('composer require jetwaves/laravel-implicit-router', $stepResult);
//        $this->info('     '.__method__.'() line:'.__line__.'     $stepResult    = '.print_r($stepResult, true));

        $this->info('STEP 2:  Installing tymon/jwt-auth to enable  jwt-Auth [Json Web Token] ');
        exec('composer require tymon/jwt-auth', $items);
//        $this->info('     '.__method__.'() line:'.__line__.'     $stepResult    = '.print_r($stepResult, true));
    }
}
