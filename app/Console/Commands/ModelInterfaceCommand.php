<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class ModelInterfaceCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:modelInterface {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new ModelInterface class';

    protected $type = 'ModelInterface';

    /**
     * Specify your Stub's location.
     */
    protected function getStub()
    {
        return  base_path() . '/stubs/modelInterface.stub';
    }

    /**
     * The root location where your new file should 
     * be written to.
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . "\Services\Interfaces\Models";
    }

}
