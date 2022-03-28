<?php

namespace SlimSkeleton\Console;

class Kernel
{
    protected $moduleCommands = [
        
    ];

    protected $defaultCommands = [
        \SlimSkeleton\Console\Commands\Generator\ConsoleGeneratorCommand::class,
        \SlimSkeleton\Console\Commands\Generator\ControllerGeneratorCommand::class,
    ];

    public function getCommands() 
    {
        return array_merge($this->defaultCommands, $this->moduleCommands);
    }
}