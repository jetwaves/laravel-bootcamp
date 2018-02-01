<?php

namespace Jetwaves\LaravelBootcamp\Commands;

use Illuminate\Console\Command;

class LaravelBootcampGreetingsConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bootcamp:hi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "[Example]     say : Hello world";

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
        //
        $this->info("\tHello world~~");
        $this->info("\t- From Your fancy package: I'm running well ");

        $this->info('STEP 1:  Installing jetwaves/route-to-controller to enable Implicit Router ');
        exec('composer require jetwaves/route-to-controller dev-master', $stepResult);
//        $this->info('     '.__method__.'() line:'.__line__.'     $stepResult    = '.print_r($stepResult, true));

        $this->info('STEP 2:  Installing tymon/jwt-auth to enable  jwt-Auth [Json Web Token] ');
        exec('composer require tymon/jwt-auth', $items);
//        $this->info('     '.__method__.'() line:'.__line__.'     $stepResult    = '.print_r($stepResult, true));

    }
}
