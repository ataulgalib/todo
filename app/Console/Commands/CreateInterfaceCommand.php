<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class CreateInterfaceCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface {name} {--f|force} {--s|service} {--c|controller} {--a|all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Interface class';

    /**
     * Execute the console command.
     *
     * @return int
     */


    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Interface';


    public function handle()
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }


        if ($this->option('all')) {
            $this->input->setOption('controller', true);
            $this->input->setOption('service', true);

            $this->createController();
            $this->createService();
        }


 
        if ($this->option('controller')) {
            $this->createController();
        }


        if ($this->option('service')) {
            $this->createService();
        }   

    }

    /**
     * Specify with create class with multiple
     */

    protected function createService(){

        $class_name = Str::studly(class_basename($this->argument('name')));
        $this->call('make:service', [
            'name' => "{$class_name}Service",
        ]);

    }

    protected function createController(){

        $class_name = Str::studly(class_basename($this->argument('name')));
        $this->call('make:controller', [
            'name' => "{$class_name}Controller",
        ]);

    }

    /**
     * Specify your Stub's location.
     */

    protected function getStub()
    {
        return  base_path() . '/stubs/interface.stub';
    }

    /**
     * The root location where your new file should 
     * be written to.
     */

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Services\Interfaces';
    }

    protected function getOptions()
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a interface, service, and controller.'],
            ['force', 'f', InputOption::VALUE_NONE, 'Generate a interface.'],
            ['controller', 'c', InputOption::VALUE_NONE, 'Generate a service and a controller.'],
            ['service', 's', InputOption::VALUE_NONE, 'Generate a service and an interface.'],
        ];
    }
}
