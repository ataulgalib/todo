<?php

namespace App\Console\Commands;

use App\Utils\StringCore;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class CreateServiceCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name} {--f|force} {--i|interface} {--c|controller} {--a|all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Service class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    public function handle()
    {

        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }

        // if($this->option('all') == 'a'){
        //     $this->input->setOption('controller', true);
        //     $this->input->setOption('interface', true);

        //     $this->createController();
        //     $this->createInterface();
        // }

        // if ($this->option('controller') == 'c') {
        //     $this->createController();
        // }

        if($this->option('all')){
            $this->input->setOption('controller', true);
            $this->input->setOption('interface', true);

            $this->createController();
            $this->createInterface();
        }

        if ($this->option('controller')) {
            $this->createController();
        }

        if ($this->option('interface')) {
            $this->createInterface();
        }
    }

    /**
     * Specify with create class with multiple
     */

    protected function createInterface(){

        $class_name = Str::studly(class_basename($this->argument('name')));
        $this->call('make:interface', [
            'name' => "{$class_name}Interface",
        ]);

    }


    protected function createController(){

        //$class_name = Str::studly(class_basename($this->argument('name')));
        $class_name = StringCore::replaceString(['Service'],'', $this->argument('name'));
        $this->call('make:controller', [
            'name' => "{$class_name}Controller",
        ]);

    }

    /**
     * Specify your Stub's location.
     */
    protected function getStub()
    {
        return  base_path() . '/stubs/service.stub';
    }

    /**
     * The root location where your new file should
     * be written to.
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . "\Services";
    }

    protected function getOptions()
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a service, interface, and controller.'],
            ['force', 'f', InputOption::VALUE_NONE, 'Generate a service.'],
            ['controller', 'c', InputOption::VALUE_NONE, 'Generate a service and a controller.'],
            ['interface', 'i', InputOption::VALUE_NONE, 'Generate a service and an interface.'],
        ];
    }

}
