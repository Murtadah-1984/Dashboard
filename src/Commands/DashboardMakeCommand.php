<?php

namespace Murtadah\Dashboard\Commands;
use Artisan;
use RuntimeException;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Menu;

class DashboardMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:make';

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
        //Get the names
        $table = $this->ask('Please Enter table Name');
        $observer = $this->ask('Do you need observer? yes/no');
        $traitContract = $this->ask('Do you need Trait & Contract? yes/no');
        $model=Str::ucfirst(Str::singular(Str::studly($table)));
        $controller=Str::remove(' ',str($model)->append('sController'));
        $apiController=Str::remove(' ',str($model)->append('sApiController'));

        //Create Trait and Contract
        if($traitContract == 'yes')
        {
            //Create Contract
            $this->makeContract($model);

            //Create Trait
            $this->MakeTraits($model);
        }
        

        //Create Model
        $this->makeModel($model);

        //Create Observer
        if($observer == 'yes')
        {
            $this->makeObserver($model);
        }
        

        //Create Migration
        $this->makeMigration($table);

        //Create Chart
        $this->makeChart($model);

        //Create Controller
        $this->makeController($apiController,$controller, $model);

        //Create Resources
        $this->makeResources($model);

        //Create Request
        $this->makeRequest($model);

        //Create Routes
        $this->generateRoutes($controller ,$table);

        //Create Views
        $this->generateViews($table);

        //Create Permissions
        $this->generatePermissions($model);

        //Create Menu
        $this->generateMenu($model, $table);        
        
    }

    public function makeModel($model)
    {
       $this->call('make:model',[
        'name' => $model,
       ]);    
       $this->info('Model Generated Successfully');
    }

    public function makeMigration($table)
    {
        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
            '--fullpath' => true,
        ]);
        $this->info('Migration Generated Successfully');
    }

    public function makeObserver($model)
    {
        $this->call('make:observer', array_filter([
            'name' => "{$model}Observer",
            '--model' => $model,
        ]));    
        $this->info('Observer Generated Successfully');
    }

    public function makeChart($model)
    {
        $this->call('make:chart', array_filter([
            'name' => "{$model}Chart",
        ]));    
        $this->info('Chart Generated Successfully');
    }

    public function makeEvent($model)
    {
        $this->call('make:event', array_filter([
            'name' => "{$model}Created",
        ]));
        $this->call('make:event', array_filter([
            'name' => "{$model}Updated",
        ])); 
        $this->call('make:event', array_filter([
            'name' => "{$model}Restored",
        ]));  
        $this->call('make:event', array_filter([
            'name' => "{$model}Deleted",
        ])); 
        $this->call('make:event', array_filter([
            'name' => "{$model}ForceDeleted",
        ])); 
        
        $this->call('event:cache');  
        $this->info('Events Generated Successfully');
    }

    public function makeController($apiController,$controller, $model)
    {
        $this->call('make:controller', array_filter([
            'name' => $controller,
            '--model' => $model,
            '--resource' =>true
        ]));  
        
        $this->call('make:controller', array_filter([
            'name' => "Api\V1\{$apiController}",
            '--model' => $model,
            '--api' =>true
        ]));
        $this->info('Controller Generated Successfully');
    }

    public function makeResources($model)
    {
        $this->call('make:resource', array_filter([
            'name' => "{$model}Resource"
        ]));  
        
        $this->info('Resources Generated Successfully');
    }

    public function makeRequest($model)
    {
        $this->call('make:request', [
            'name' => "Store/Store{$model}Request",
        ]);

        $this->call('make:request', [
            'name' => "Update/Update{$model}Request",
        ]);

        $this->info('Request Generated Successfully');
    }


    public function makeContract($model)
    {
        
        copy(base_path('stubs/contract.php'), app_path("Contracts/{$model}Contract.php"));
        $line0="interface ".$model."Contract"."\n";
        $line1="{"."\n\n\n\n\n";
        $line2="}";
        file_put_contents(
            app_path("Contracts/{$model}Contract.php"),
            $line0.$line1.$line2
            ,
            FILE_APPEND
        );
        
        $this->info('Policy Generated Successfully');
    }

    public function MakeTraits($model)
    {
        
        copy(base_path('stubs/trait.php'), app_path("Traits/{$model}Trait.php"));
        $line0="trait ".$model."Trait"."\n";
        $line1="{"."\n\n\n\n\n";
        $line2="}";
        file_put_contents(
            app_path("Traits/{$model}Trait.php"),
            $line0.$line1.$line2
            ,
            FILE_APPEND
        );
        $this->info('Trait Generated Successfully');
    }

    public function generateRoutes($apiController,$controller ,$table)
    { 
        $controllerClass="\App\Http\Controllers\\$controller::class";
        $apiControllerClass="\App\Http\Controllers\\Api\\V1\\$apiController::class";
        $line0="// $table Routes"."\n";
        $line1="Route::middleware('auth')->group(function () {"."\n";
        $line2="Route::resource('{$table}', {$controllerClass});"."\n";
        $line3="});"."\n";
        file_put_contents(
            base_path('routes/web.php'),
            $line0.$line1.$line2.$line3
            ,
            FILE_APPEND
        );
        $line4="// $table Api Routes"."\n";
        $line5="Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1', 'middleware' => ['auth:sanctum']], function () {"."\n";
        $line6="Route::apiResource('{$table}', {$apiController});"."\n";
        $line7="});"."\n";

        file_put_contents(
            base_path('routes/api.php'),
            $line4.$line5.$line6.$line7
            ,
            FILE_APPEND
        );
        $this->info('Routes Generated Successfully');
    }

    public function generateViews($table)
    {
        (new Filesystem)->ensureDirectoryExists(resource_path("views/{$table}s"));
        copy(base_path('stubs/index.blade.php'), resource_path("views/{$table}/index.blade.php"));
        copy(base_path('stubs/view.blade.php'), resource_path("views/{$table}/view.blade.php"));
        copy(base_path('stubs/add.blade.php'), resource_path("views/{$table}/add.blade.php"));
        copy(base_path('stubs/edit.blade.php'), resource_path("views/{$table}/edit.blade.php"));
        copy(base_path('stubs/action.blade.php'), resource_path("views/{$table}/action.blade.php"));

        $this->info('Views Generated Successfully');
    }

    public function generatePermissions($table_name)
    {
        $permissions=Permission::generateFor($table_name);

        Role::find(1)->permissions()->attach($permissions);

        $this->info('Permissions Generated Successfully');
    }

    public function generateMenu($model,$table)
    {
        Menu::generate($model, $table);
        $this->info('Menu Generated Successfully');
    }

}