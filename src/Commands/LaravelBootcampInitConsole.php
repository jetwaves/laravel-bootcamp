<?php

namespace Jetwaves\LaravelBootcamp\Commands;

use Illuminate\Console\Command;
use Jetwaves\EditArrayInFile\Editor;
use Jetwaves\LaravelExplorer\LaravelDirUtil55;

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
        $execPrecedentCommands = true;
        if($execPrecedentCommands){

            $this->info('STEP 1:  Installing tymon/jwt-auth to enable  jwt-Auth [Json Web Token] ');
            exec('composer require tymon/jwt-auth', $stepResult);


            $this->info('STEP 2:  Deploy database structure migration files  ');
            $src = dirname(__DIR__).'/Templates/database/2018_01_01_000000_create_jwt_user_table.php';
            $dest = LaravelDirUtil55::getMigrationPath().'/2018_01_01_000000_create_jwt_user_table.php';
            copy($src, $dest);


            $this->info('STEP 3:  Apply database changes  ');
            exec('php artisan migrate', $stepResult);
            echo '   STEP 3   $stepResult  = '.print_r($stepResult, true).PHP_EOL;


            $this->info('STEP 4:  add jwt auth middleware to app/Http/Middleware  ');
            $src = dirname(__DIR__).'/Templates/jwt/VerifyJWTToken.php';
            $dest = LaravelDirUtil55::getMiddlewarePath().'/VerifyJWTToken.php';
            copy($src, $dest);


            $this->info('STEP 5:  add providers and aliases declaration of tymon/jwt-auth components   ');
            $configAppEditor = new Editor( LaravelDirUtil55::getConfigPath().'/app.php');
            $configAppEditor->where('providers',[], Editor::TYPE_KV_PAIR)
                ->insert('Tymon\JWTAuth\Providers\JWTAuthServiceProvider::class,'.PHP_EOL, Editor::INSERT_TYPE_ARRAY);
            $configAppEditor->save();
            $configAppEditor->where('aliases',[], Editor::TYPE_KV_PAIR)
                ->insert(" 'JWTAuth' => Tymon\JWTAuth\Facades\JWTAuth::class,".PHP_EOL, Editor::INSERT_TYPE_ARRAY);
            $configAppEditor->save()->flush();


            $this->info('STEP 6:  add jwt-auth as route middleware ');
            $appHttpKernelEditor = new Editor( LaravelDirUtil55::getAppPath().'/Http/Kernel.php');
            $appHttpKernelEditor->where('$routeMiddleware',[], Editor::TYPE_VARIABLE);
            $appHttpKernelEditor->insert("'jwt.auth' => \App\Http\Middleware\VerifyJWTToken::class,".PHP_EOL, Editor::INSERT_TYPE_ARRAY);
            $appHttpKernelEditor->save()->flush();


            $this->info('STEP 7:  publish tymon/jwt-auth configuration file');
            exec('php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\JWTAuthServiceProvider"', $stepResult);
            echo '   STEP 7   $stepResult  = '.print_r($stepResult, true).PHP_EOL;


            $this->info('STEP 8:  change authentication user model ');
            $configJwtEditor = new Editor( LaravelDirUtil55::getConfigPath().'/jwt.php');
            $configJwtEditor->where("'user' => 'App\User'",[], Editor::TYPE_RAW );
            $configJwtEditor->insert("  'user' => 'App\Models\JwtUserModel',", Editor::INSERT_TYPE_AFTER);
            $editArea = $configJwtEditor->getEditArea();
            $editArea = array_splice($editArea, 1, 1);
            $configJwtEditor->setEditArea($editArea);
            $configJwtEditor->save()->flush();

            $this->info('STEP 9:  add jwt auth user model  ');
            mkdir(LaravelDirUtil55::getModelPath());
            $src = dirname(__DIR__).'/Templates/Models/JwtUserModel.php';
            $dest = LaravelDirUtil55::getModelPath().'/JwtUserModel.php';
            copy($src, $dest);

            $this->info('STEP 10:  modify auth user model ');
            $configAuthEditor = new Editor( LaravelDirUtil55::getConfigPath().'/auth.php');
            $configAuthEditor->where("providers",[], Editor::TYPE_KV_PAIR );
            $configAuthEditor->find("model", Editor::FIND_TYPE_ALL);
            $configAuthEditor->insert("             'model' => App\Models\JwtUserModel::class,".PHP_EOL, Editor::INSERT_TYPE_AFTER);
            $configAuthEditor->delete();
            $configAuthEditor->save()->flush();

            $this->info('STEP 11:  add jwt auth controllers ');
            $src = dirname(__DIR__).'/Templates/Controllers/JwtUserController.php';
            $dest = LaravelDirUtil55::getControllerPath().'/JwtUserController.php';
            copy($src, $dest);
            $src = dirname(__DIR__).'/Templates/Controllers/User.php';
            $dest = LaravelDirUtil55::getControllerPath().'/User.php';
            copy($src, $dest);


            $this->info('STEP 12:  add routing rules for API use'); // must after step 11.
            $routeApiEditor = new Editor( LaravelDirUtil55::getRouterPath().'/api.php');
            $data =
                'Route::group([\'middleware\' => \'jwt.auth\'], function () {
    $api = app(\'Jetwaves\LaravelImplicitRouter\Router\');
    $api->controller(\'withauth\', \'App\Http\Controllers\JwtUserController\');
});
        
$api = app(\'Jetwaves\LaravelImplicitRouter\Router\');
$api->controller(\'noauth\', \'App\Http\Controllers\JwtUserController\');
        ';
            $routeApiEditor->append($data);
        }









    }
}
