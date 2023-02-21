<?php

namespace Murtadah\Dashboard\Commands;
use Artisan;
use RuntimeException;
use Illuminate\Support\Pluralizer;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use App\Models\Permission;
use App\Models\Menu;

class GenerateModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:gen';

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
        $model = $this->ask('Please Enter Model Name');
        $table = $this->ask('Please Enter table Name');
        $controller = $this->ask('Please Enter Controller Name');

        //Create Contract
        $this->makeContract($model);

        //Create Trait
        $this->MakeTraits($model);

        //Create Model
        $this->makeModel($model);

        //Create Observer
        $this->makeObserver($model);

        //Create Migration
        $this->makeMigration($table);

        //Create Chart
        $this->makeChart($model);

        //Create Controller
        $this->makeController($controller, $model);

        //Create Request
        $this->makeRequest($model);

        //Create Policy
        $this->makePolicy($model, $table);

        //Create Routes
        $this->generateRoutes($controller ,$table);

        //Create Views
        $this->generateViews($model);

        //Create Permissions
        $this->generatePermissions($model);

        //Create Menu
        $this->generateMenu($model);

        
        
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

    public function makeController($controller, $model)
    {
        $this->call('make:controller', array_filter([
            'name' => $controller,
            '--model' => $model,
        ]));    
        $this->info('Controller Generated Successfully');
    }

    public function makeRequest($model)
    {
        $this->call('make:request', [
            'name' => "Store{$model}Request",
        ]);

        $this->call('make:request', [
            'name' => "Update{$model}Request",
        ]);

        $this->info('Request Generated Successfully');
    }

    public function makePolicy($model, $table)
    {
        $this->call('make:policy', [
            'name' => "{$model}Policy",
            '--model' =>$model,
        ]);
        
        $this->info('Policy Generated Successfully');
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

    public function generateRoutes($controller ,$table)
    { 
        $controllerClass="\App\Http\Controllers\\$controller::class";
        $line0="// $table Routes"."\n";
        $line1="Route::middleware('auth')->group(function () {"."\n";
        $line2="Route::post('$table/restore', [$controllerClass, 'restore'])->name('$table.restore');"."\n";
        $line3="Route::resource('{$table}', {$controllerClass});"."\n";
        $line4="});"."\n";
        file_put_contents(
            base_path('routes/web.php'),
            $line0.$line1.$line2.$line3.$line4
            ,
            FILE_APPEND
        );
        $this->info('Routes Generated Successfully');
    }

    public function generateViews($model)
    {
        (new Filesystem)->ensureDirectoryExists(resource_path("{$model}s"));
        copy(base_path('stubs/index.blade.php'), resource_path("{$model}s/index.blade.php"));

        $this->info('Views Generated Successfully');
    }

    public function generatePermissions($table_name)
    {
        Permission::generateFor($table_name);

        $this->info('Permissions Generated Successfully');
    }

    public function generateMenu($model)
    {
        Menu::generate($model);
        $this->info('Menu Generated Successfully');
    }

}