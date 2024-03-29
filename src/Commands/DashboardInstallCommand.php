<?php

namespace Murtadah\Dashboard\Commands;
use Artisan;
use RuntimeException;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class DashboardInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:install
                            {--composer=global : Absolute path to the Composer binary which should be used to install packages}
                            {--php_version=php : Php version command, like `sail` or `./vendor/bin/sail` or `docker-compose up...`}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Murtadah Haddad base dashboard that have users and roles with permissions also it will generate views and models';

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
            // Change DB Engine
            config(['database.connections.mysql.engine' => 'InnoDB']);

            // Install Laravel UI
            $this->call('ui',[
                'type'=>'bootstrap',
                '--auth'=>true,
            ]);

            // Install Laravel Octane
            $this->call('octane:install',[
                '--server'=>'roadrunner',
            ]);

            
            //Copy Controllers
            (new Filesystem)->copyDirectory(__DIR__ . '/../Http/Controllers', app_path('Http/Controllers/'));

            //Copy Request
            (new Filesystem)->ensureDirectoryExists(app_path('Http/Requests'));
            (new Filesystem)->copyDirectory(__DIR__ . '/../Http/requests', app_path('Http/Requests/'));

            //Copy vite build
            (new Filesystem)->ensureDirectoryExists(public_path('build'));
            (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/build', public_path('build/'));

            //Copy Models
            (new Filesystem)->copyDirectory(__DIR__ . '/../Models', app_path('Models/'));

            //Copy Route
            (new Filesystem)->copyDirectory(__DIR__ . '/../../routes', base_path('routes/'));

            //Copy Contract
            (new Filesystem)->ensureDirectoryExists(app_path('Contracts'));
            (new Filesystem)->copyDirectory(__DIR__ . '/../Contracts', app_path('Contracts/'));

            //Copy Traits
            (new Filesystem)->ensureDirectoryExists(app_path('Traits'));
            (new Filesystem)->copyDirectory(__DIR__ . '/../Traits', app_path('Traits/'));

            // Copy Seeders
            (new Filesystem)->ensureDirectoryExists(base_path('database/seeders'));
            (new Filesystem)->copyDirectory(__DIR__ . '/../../database/seeders', base_path('database/seeders/'));

            //Copy views
            (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views', resource_path('views/'));

            //Copy Stubs
            (new Filesystem)->ensureDirectoryExists(base_path('stubs'));
            (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs', base_path('stubs/'));

            //Copy App Service Provider
            copy(__DIR__ . '/../AppServiceProvider.php', app_path('Providers/AppServiceProvider.php'));

            //Copy Event Service Provider
            copy(__DIR__ . '/../EventServiceProvider.php', app_path('Providers/EventServiceProvider.php'));

            //Copy Auth Service Provider
            copy(__DIR__ . '/../AuthServiceProvider.php', app_path('Providers/AuthServiceProvider.php'));

            //Copy Route Service Provider
            copy(__DIR__ . '/../RouteServiceProvider.php', app_path('Providers/RouteServiceProvider.php'));

            //Copy Vite
            copy(__DIR__ . '/../../resources/vite.config.js', base_path('vite.config.js'));

            // Copy Dashboard Config File 
            copy(__DIR__ . '/../../config/dashboard.php', config_path('dashboard.php'));

            // Publish config for spatie/ news letter
            $this->call('vendor:publish',[
                '--tag'=>"newsletter-config",
            ]);

            
            $this->replaceWithAdminLTETheme();

            // Migratation
            $this->call('migrate:fresh',[
                '--seed'=>true,
            ]);
            

        
    }

 

    protected function replaceWithAdminLTETheme()
    {
        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                    'jquery'=> '^3.3.1',
                    'resolve-url-loader' => '^4.0.0',
                    'bootstrap' => '~4.6.1',
                    'popper.js' => '^1.14.3',
                ] + $packages;
        });

        // Views...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth/passwords'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/auth', resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/auth/passwords', resource_path('views/auth/passwords'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/layouts', resource_path('views/layouts'));

        // Assets
        (new Filesystem)->ensureDirectoryExists(resource_path('js'));
        (new Filesystem)->ensureDirectoryExists(public_path('css'));
        (new Filesystem)->ensureDirectoryExists(public_path('js'));
        (new Filesystem)->ensureDirectoryExists(public_path('images'));
        (new Filesystem)->ensureDirectoryExists(public_path('webfonts'));
        (new Filesystem)->ensureDirectoryExists(public_path('build'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/build', public_path('build'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/css', public_path('css'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/js', public_path('js'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/images', public_path('images'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/webfonts', public_path('webfonts'));

        copy(__DIR__ . '/../../resources/views/home.blade.php', resource_path('views/home.blade.php'));
        copy(__DIR__ . '/../../resources/js/bootstrap.js', resource_path('js/bootstrap.js'));

        $this->runCommands(['npm install','npm i laravel-datatables-vite --save-dev' ]);
        file_put_contents(
            resource_path('js/app.js'),
            file_get_contents(__DIR__ . '/../../resources/js/app.js'),
            FILE_APPEND
        );
        (new Filesystem)->ensureDirectoryExists(resource_path('sass'));
        file_put_contents(
            resource_path('sass/app.scss'),
            file_get_contents(__DIR__ . '/../../resources/sass/app.scss'),
            FILE_APPEND
        );
        //$this->runCommands(['npm run build']);
        $this->components->info('Laravel UI scaffolding replaced successfully.');
    }



    /**
     * Installs the given Composer Packages into the application.
     * Taken from https://github.com/laravel/breeze/blob/1.x/src/Console/InstallCommand.php
     *
     * @param mixed $packages
     * @return void
     */
    protected function requireComposerPackages($packages)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            is_array($packages) ? $packages : func_get_args()
        );

        (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }

    /**
     * Update the "package.json" file.
     * Taken from https://github.com/laravel/breeze/blob/1.x/src/Console/InstallCommand.php
     *
     * @param callable $callback
     * @param bool $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    /**
     * Run the given commands.
     * Taken from https://github.com/laravel/breeze/blob/1.x/src/Console/InstallCommand.php
     *
     * @param  array  $commands
     * @return void
     */
    protected function runCommands($commands)
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> '.$e->getMessage().PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    '.$line);
        });
    }

}