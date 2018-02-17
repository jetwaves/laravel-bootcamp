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
     *  "php artisan bootcamp:hi "  command is handled here
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->info("\tHello world~~");
        $this->info("\t- From Your fancy package: I'm running well ");

    }
}
