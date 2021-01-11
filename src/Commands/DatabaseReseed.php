<?php

namespace Sethios\Tools\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class DatabaseReseed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:reseed
                            {model="" : Select model name to reseed}
                            {amount=20 : Amount of seeds to plant }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate the database and reseed it';

    protected $model;

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
     * Initializes the command just after the input has been validated.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        $this->model = $this->argument('model');
        $GLOBALS['seed_amount'] = $this->argument('amount');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $config = config('dbseeder.'.Pluralizer::singular($this->model));

        $reset = $config['reset'] ?? '';
        $tables = $config['tables'] ?? array_map('reset', DB::select('SHOW TABLES'));
        $class = $config['class'] ? ['--class' => $config['class']] : [];

        $ask = false;
        if (!App::environment(['local', 'staging', 'development', 'dev'])) {
            $ask = true;
            $this->error('Application is not in development.');
        }
        if (empty($config)) {
            $ask = true;
            $this->error('Unknown model, if you continue ALL tables will be reset.');
        }
        $are_you_sure = $ask ? $this->ask('Are you sure you wish to continue? (yes|no)') : 'yes';
        $are_you_sure = strtolower($are_you_sure);

        if ($are_you_sure == 'yes' || $are_you_sure == 'y') {
            Schema::disableForeignKeyConstraints();
                if ($reset) {
                    Artisan::call('migrate:refresh', ['--path' => '/database/migrations/' . $reset . '.php'], $this->output);
                }
                foreach ($tables as $table_name) {
                    // Skip the migrations table
                    if ($table_name == 'migrations') {
                        continue;
                    }
                    $this->info('Cleaning table: ' . $table_name);
                    DB::table($table_name)->truncate();
                }

            Schema::enableForeignKeyConstraints();

            $this->info('Migrating and seeding the database...');
            Artisan::call('db:seed', $class, $this->output);
        }
    }
}
