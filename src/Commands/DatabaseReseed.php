<?php

namespace Sethios\Tools\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
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
        $are_you_sure = 'xxx';

        switch ($this->model) {
            case 'option':
                $tables = ['options'];
                $class = ['--class' => 'OptionSeeder'];
            break;

            case 'user':
                $reset = "2020_12_01_100000_create_users_table";
                $tables = ['users'];
                $class = ['--class' => 'UserSeeder'];
            break;

            case 'role':
                $tables = [
                    'roles',
                    'permissions',
                    'model_has_permissions',
                    'model_has_roles',
                    'role_has_permissions'
                ];
                $class = ['--class' => 'RoleSeeder'];
            break;

            case 'shift':
                $reset = "2020_12_01_310000_create_shifts_table";
                $tables = ['shifts'];
                $class = ['--class' => 'ShiftSeeder'];
            break;

            case 'report':
                $reset = "2020_12_01_320000_create_reports_table";
                $tables = ['reports'];
                $class = ['--class' => 'ReportSeeder'];
            break;

            case 'client':
                $reset = "2020_12_01_330000_create_clients_table";
                $tables = ['clients'];
                $class = ['--class' => 'ClientSeeder'];
            break;

            case 'donation':
                $reset = "2020_12_01_340000_create_donations_table";
                $tables = ['donations'];
                $class = ['--class' => 'DonationSeeder'];
            break;

            default:
                $are_you_sure = $this->ask('Unknown model, if you continue ALL tables will be reset. Are you sure to continue? (yes|no)');
                $tables = array_map('reset', DB::select('SHOW TABLES'));
                $class = [];
            break;
        }

        $are_you_sure = strtolower($are_you_sure);

        if ($are_you_sure == 'yes' || $are_you_sure == 'y' || $are_you_sure == 'xxx') {
            Schema::disableForeignKeyConstraints();
                if (isset($reset)) {
                    Artisan::call('migrate:refresh', ['--path' => '/database/migrations/' . $reset . '.php'], $this->output);
                }
                foreach ($tables as $table_name) {
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
