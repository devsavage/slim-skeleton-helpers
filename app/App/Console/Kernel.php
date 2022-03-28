<?php

namespace App\Console;

class Kernel
{
    protected $moduleCommands = [
        
    ];

    protected $defaultCommands = [
        \App\Console\Commands\Generator\ConsoleGeneratorCommand::class,
        \App\Console\Commands\Generator\ControllerGeneratorCommand::class,
    ];

    public function getCommands() 
    {
        return array_merge($this->defaultCommands, $this->moduleCommands);
    }
}