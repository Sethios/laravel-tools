<?php

namespace Sethios\Tools\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMvc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:mvc 
                            {model="" : Name of the model you want to generate, lowercase and as singleton (ex: user)}
                            {--m : Include Model and migration}
                            {--c : Include Controller}
                            {--b : Include Blade, CSS and JS files}
                            {--s : Include Seeder and Factory}
                            {--l : Include logic in AppServiceProvider, Events, Listeners and Observers}
    ';

    protected $options = [];

    protected $model;
    protected $models;

    protected $fileName;
    protected $fileExtension;
    protected $fileRoute;

    protected $template = "";

    protected $templateArray = [
        ['n' => 'model', 'e' => 'php', 'u' => ['m']],
        ['n' => 'request', 'e' => 'php', 'u' => ['m', 'c']],
        ['n' => 'controller', 'e' => 'php', 'u' => ['c']],

        ['n' => 'event', 'e' => 'php', 'u' => ['l']],
        ['n' => 'listenerDelete', 'e' => 'php', 'u' => ['l']],
        ['n' => 'listenerStore', 'e' => 'php', 'u' => ['l']],
        ['n' => 'listenerUpdate', 'e' => 'php', 'u' => ['l']],
        ['n' => 'observer', 'e' => 'php', 'u' => ['l']],

        ['n' => 'migration', 'e' => 'php', 'u' => ['m']],
        ['n' => 'factory', 'e' => 'php', 'u' => ['s']],
        ['n' => 'seeder', 'e' => 'php', 'u' => ['s']],

        ['n' => 'lang', 'e' => 'php', 'u' => ['b', 'c']],
        ['n' => 'model', 'e' => 'js', 'u' => ['b']],
        ['n' => 'index', 'e' => 'blade.php', 'u' => ['b']],
        ['n' => 'new', 'e' => 'blade.php', 'u' => ['b']],
        ['n' => 'edit', 'e' => 'blade.php', 'u' => ['b']],
        ['n' => 'form', 'e' => 'blade.php', 'u' => ['b']],
        ['n' => 'listItem', 'e' => 'blade.php', 'u' => ['b']],
        ['n' => 'actions', 'e' => 'blade.php', 'u' => ['b']],
        ['n' => 'inputs', 'e' => 'blade.php', 'u' => ['b']],
    ];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate some basic structure for a new model';

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

        if($this->option('m')) $this->options[] = 'm';
        if($this->option('c')) $this->options[] = 'c';
        if($this->option('b')) $this->options[] = 'b';
        if($this->option('s')) $this->options[] = 's';

        $this->model = $this->argument('model');
        if (strpos($this->model, '_') !== false) {
            $plural_tmp = explode('_', $this->model);
            $last_word = count($plural_tmp) - 1;
            $plural_tmp[$last_word] = Pluralizer::plural($plural_tmp[$last_word]);
            $this->models = implode('_', $plural_tmp);
        }
        else {
            $this->models = Pluralizer::plural($this->model);
        }

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Schema::disableForeignKeyConstraints();
        //     DB::table($table_name)->truncate();
        // Schema::enableForeignKeyConstraints();
        $debug = false;




        $this->info('Creating new scaffolding for the model');
        //Artisan::call('make:model', $this->formatName('model'), $this->output);

        // Process files
        foreach($this->templateArray as $file) {
            if (!$this->include($file['u'])) {
                continue;
            }
            $this->fileName = $file['n'];
            $this->fileExtension = $file['e'];

            $this->parseFileRoute();
            $content = $this->template()->prepareTemplate()->getTemplateContent();

            if (!$debug) $processFile = fopen($this->fileRoute, 'w');

            if (!$debug) fwrite($processFile, $content);
            $this->info('Creating file: ' . $this->fileRoute);
            if (!$debug) fclose($processFile);
        }

        // Append routes to web.php
        if ($this->include(['c', 'b'])) {
            $this->info('Generating routes');
            if (!$debug) $this->insertAt($this->template('routes')->prepareTemplate()->getTemplateContent(), 'routes/web.php', '// Create MVC');
        }

        // Append sidebar block
        if ($this->include(['b'])) {
            $this->info('Setting up sidebar');
            if (!$debug) $this->insertAt($this->template('sidebar', 'blade.php')->prepareTemplate()->getTemplateContent(), 'resources/views/layouts/partials/sidebar.blade.php', '{{-- Create MVC --}}');
        }

        // Append events to service provider
        if ($this->include(['l'])) {
            $this->info('Setting up EventServiceProvider');
            if (!$debug) $this->insertAt($this->template('events')->prepareTemplate()->getTemplateContent(), 'app/Providers/EventServiceProvider.php', '// Create MVC');
        }

        // Append observer
        if ($this->include(['l'])) {
            $this->info('Setting up AppServiceProvider');
            if (!$debug) $this->insertAt($this->replaceStringWithModel($this->replaceStringWithModel("¤ModelP¤::observe(¤ModelP¤Observer::class);")), 'app/Providers/AppServiceProvider.php', '// Create MVC');
            if (!$debug) $this->insertAt($this->replaceStringWithModel(
                $this->replaceStringWithModel("use App\Observers\¤ModelP¤Observer;".PHP_EOL."use App\Models\¤ModelP¤;")),
                'app/Providers/AppServiceProvider.php',
                '// use Create MVC'
            );
        }

        // Append seeder
        if ($this->include(['s'])) {
            $this->info('Setting up Seeder');
            if (!$debug) $this->insertAt($this->replaceStringWithModel($this->replaceStringWithModel("\$this->call(¤ModelP¤Seeder::class);")), 'database/seeds/DatabaseSeeder.php', '// Create MVC');
        }

        // Append to app.js
        if ($this->include(['b'])) {
            $this->info('Setting up app.js');
            if (!$debug) $this->insertAt($this->replaceStringWithModel("import './includes/¤modelC¤';"), 'resources/js/app.js', '// Create MVC');
        }

        $this->warn("Generation complete!");
    }

    /**
     * Check whether to include a logic in the generation or not depending on set flags/options
     *
     * @param mixed $flag
     * @return boolean
     */
    private function include($flag = null) : bool
    {
        if (empty($this->options)) return true;
        if (is_array($flag)) return !empty(array_intersect($flag, $this->options));
        if (is_string($flag)) return in_array($flag, $this->options);
        return false;
    }

    /**
     * Prepend string at a specific spot defined by $at
     *
     * @param string $needle | String you want to ad
     * @param string $file | File to append/prepend value from $needle
     * @param string $at | Sting to search for in $file to prepend $needle. If left empty, the $needle will be appended to the end of the $file
     */
    private function insertAt(string $needle, string $file, string $at = "")
    {
        $str = file_get_contents($file);

        if ($at != "") {
            file_put_contents($file, str_replace($at, $needle.PHP_EOL.$at,$str), LOCK_EX);
        }
        else {
            file_put_contents($file, $str, FILE_APPEND | LOCK_EX);
        }
    }

    /**
     * Parse the route to the template file
     * 
     * @return $this->fileRoute
     */
    private function parseFileRoute()
    {
        switch($this->fileName) {
            // Initialize the model
            case 'model':
                if ($this->fileExtension == 'js')
                    $this->fileRoute = "resources/js/includes/".$this->caseConversion($this->model, 'camel').".js";
                else
                    $this->fileRoute = "app/Models/".$this->caseConversion($this->model, 'pascal').".php";
            break;
            case 'request':
                $this->fileRoute = "app/Http/Requests/".$this->caseConversion($this->model, 'pascal')."Request.php";
            break;
            case 'controller':
                $this->fileRoute = "app/Http/Controllers/".$this->caseConversion($this->model, 'pascal')."Controller.php";
            break;

            // Events and logging
            case 'event':
                $this->fileRoute = "app/Events/".$this->caseConversion($this->model, 'pascal')."Event.php";
            break;
            case 'listenerDelete':
                $this->fileRoute = "app/Listeners/".$this->caseConversion($this->model, 'pascal')."Deleted.php";
            break;
            case 'listenerStore':
                $this->fileRoute = "app/Listeners/".$this->caseConversion($this->model, 'pascal')."Stored.php";
            break;
            case 'listenerUpdate':
                $this->fileRoute = "app/Listeners/".$this->caseConversion($this->model, 'pascal')."Updated.php";
            break;
            case 'observer':
                $this->fileRoute = "app/Observers/".$this->caseConversion($this->model, 'pascal')."Observer.php";
            break;

            // Database
            case 'migration':
                $this->fileRoute = "database/migrations/" . date("Y_m_d_His") . "_create_" . $this->caseConversion($this->models, '') . "_table.php";
            break;
            case 'factory':
                $this->fileRoute = "database/factories/".$this->caseConversion($this->model, 'pascal')."Factory.php";
            break;
            case 'seeder':
                $this->fileRoute = "database/seeds/".$this->caseConversion($this->model, 'pascal')."Seeder.php";
            break;

            // Resources
            case 'lang':
                $this->fileRoute = "resources/lang/hr/".$this->caseConversion($this->model, '').".php";
            break;
            case 'index':
                $this->fileRoute = "resources/views/".$this->caseConversion($this->model, 'camel')."/index.blade.php";
            break;
            case 'new':
                $this->fileRoute = "resources/views/".$this->caseConversion($this->model, 'camel')."/new.blade.php";
            break;
            case 'edit':
                $this->fileRoute = "resources/views/".$this->caseConversion($this->model, 'camel')."/edit.blade.php";
            break;
            case 'form':
                $this->fileRoute = "resources/views/".$this->caseConversion($this->model, 'camel')."/partials/form.blade.php";
            break;
            case 'listItem':
                $this->fileRoute = "resources/views/".$this->caseConversion($this->model, 'camel')."/partials/".$this->caseConversion($this->model, 'camel')."ListItem.blade.php";
            break;
            case 'actions':
                $this->fileRoute = "resources/views/".$this->caseConversion($this->model, 'camel')."/partials/actions.blade.php";
            break;
            case 'inputs':
                $this->fileRoute = "resources/views/".$this->caseConversion($this->model, 'camel')."/partials/inputs.blade.php";
            break;


            default:
                die($this->fileRoute . " is not a valid option!");
            break;
        }

        // Create any missing folder
        preg_match('/.*\//', $this->fileRoute, $match);
        if (!is_dir($match[0])) {
            mkdir($match[0], 0755, true);
            $this->info('Creating new folder: ' . $match[0]);
        }
    }

    /**
     * Get the current template file and populate it in the "template" attribute
     *
     * @param string $fileName
     * @param string $fileExtension | template folder name
     * 
     * @return $this
     */
    public function template(string $fileName = "", string $fileExtension = "")
    {
        if ($fileName != "") $this->fileName = $fileName;
        if ($fileExtension != "") $this->fileExtension = $fileExtension;

        if ( $this->fileName . $this->fileExtension == "") die("Name and/or extension missing!");

        $this->template = file_get_contents(dirname(__DIR__).'/Templates/'. $this->fileExtension . '/' . $this->fileName . '.' . $this->fileExtension);

        // Reset the file name and extension to default
        $this->fileName = "";
        $this->fileExtension = "php";

        return $this;
    }

    /**
     * Clean up the template and replace template strings with proper class and variable names
     *
     * @return $this
     */
    private function prepareTemplate()
    {
        $this->template = $this->replaceStringWithModel($this->template);
        $this->template = $this->replaceStringWithModel($this->template);
        $this->template = $this->replaceStringWithModel($this->template);
        $this->template = $this->replaceStringWithModel($this->template);

        return $this;
    }

    /**
     * Replace templated string
     *
     * @param string $string
     * @return string $string
     */
    public function replaceStringWithModel(string $string)
    {
        // snake_case
        $string = preg_replace('/\¤_model\¤/i', $this->model, $string);
        $string = preg_replace('/\¤_models\¤/i', $this->models, $string);

        // PascalCase
        $string = preg_replace('/\¤ModelP\¤/i', $this->caseConversion($this->model, 'pascal'), $string);
        $string = preg_replace('/\¤ModelsP\¤/i', $this->caseConversion($this->models, 'pascal'), $string);

        // kebab-case
        $string = preg_replace('/\¤-model\¤/i', $this->caseConversion($this->model, 'kebab'), $string);
        $string = preg_replace('/\¤-models\¤/i', $this->caseConversion($this->models, 'kebab'), $string);

        // camelCase
        $string = preg_replace('/\¤modelC\¤/i', $this->caseConversion($this->model, 'camel'), $string);
        $string = preg_replace('/\¤modelsC\¤/i', $this->caseConversion($this->models, 'camel'), $string);

        return $string;
    }

    /**
     * Get template content as string
     *
     * @return $this->template
     */
    private function getTemplateContent()
    {
        return $this->template;
    }

    private function caseConversion(string $string, string $case)
    {
        switch ($case) {
            case 'pascal':
                return str_replace('_', '', ucwords($string, '_'));
            break;
            case 'kebab':
                return str_replace('_', '-', $string);
            break;
            case 'camel':
                $string_tmp = explode('_', ucwords($string, '_'));
                $string_tmp[0] = lcfirst($string_tmp[0]);
                return implode('', $string_tmp);
            break;
        }

        return $string;
    }
}
