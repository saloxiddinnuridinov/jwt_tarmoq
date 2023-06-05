<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Console\ModelMakeCommand;
class DocumentationGenerator extends Command
{
    /*
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "make:doc {param}";
 
    /*
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generates api docs';

    /*
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct()
    {
       
        parent::__construct();
    }

    /*
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        echo "Starting...\n";
// API/V1/SalomController
        $param = $this->argument('param');

        $paramClone = $param;

        $array = explode("\\", $param);

        $fname = $array[count($array) - 1];

        $param = str_replace('controller', "", $fname);
        $param = str_replace('Controller', "", $param);
        $param = ucfirst($param);
        
        $path = str_replace($fname, "", $paramClone);

        $fileNameController = $param . 'Controller.php';
        $resource_name = $param . 'Resource';
        $model_name = $param;
        
        echo "Model, migration, seeder, factory are generating...\n";

        Artisan::call("make:model $model_name -msf");
        echo "Resource is generating...\n";

        Artisan::call("make:resource $resource_name");
        echo "Controller is generating...\n";

        $text = file_get_contents("controller_helper.txt", true);
        $text = str_replace("{controller_name}", $param . 'Controller', $text);
        $text = str_replace("{resource_name}", $resource_name, $text);
        $text = str_replace("{model_name}", $model_name, $text);
        $text = str_replace("{path}", $path, $text);
        
        Storage::disk("controller")->put($path."/".$fileNameController, $text);
        
        echo "End...\n";
        return 0;
    }
}
