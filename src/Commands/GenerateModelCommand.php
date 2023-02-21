<?php

namespace Murtadah\Dashboard\Commands;
use Artisan;
use RuntimeException;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use App\Models\Permission;

class GenerateModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:gen {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make model, controller , request, policy';

    /**
     * The artisan command to run. Default is php.
     *
     * @var string
     */
    protected string $php_version;

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
     * @return void
     */
    public function handle()
    {
        $modelClass=ucfirst($this->argumnet('model'));
        $table=$this->argumnet('model')."s";
        $controllerClass=$modelClass."sController";
        $this->makeModel($modelClass);
        $this->info($model.'Model Generated Successfully');
        $this->makeController($controllerClass, $modelClass);
        $this->info($controllerClass.'Generated Successfully');
    }

    public function makeModel($name)
    {
       $this->call('make:model',[
        $name, '-m',
       ]);    
    }

    public function makeController($controllerClass, $modelClass)
    {
        $this->call('make:controller',[
            $controllerClass, $modelClass,
           ]);      
    }

    public function makeRequest($model)
    {
          
    }

    public function makePolicy($modelClass, $table)
    {
        $policy=$modelClass."Policy";
        $this->call('make:policy',[
            $policy, $modelClass, $table
           ]);        
    }

    public function generateRoutes($controller ,$table)
    { 
        $controllerClass="\App\Http\Controllers\".$controller.\"::class";
        file_put_contents(
            base_path('routes/web.php'),
            (
                Route::middleware('auth')->group(function () {
                    Route::post($table/restore, [$controllerClass, 'restore'])->name("$table.'.restore'");
                    Route::resource("$table", \App\Http\Controllers\Controller::class);
                })
            )
            ,
            FILE_APPEND
        );
    }

    public function generateViews($controller, $table)
    {
        (new Filesystem)->ensureDirectoryExists(resource_path($table));
        copy(__DIR__ . '/../../stubs/index.blade.php', resource_path("views/{{$table}}/index.blade.php"));
    }

    public function generatePermissions($table_name)
    {
        Permission::generateFor($table_name);
    }

}