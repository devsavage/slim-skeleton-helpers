<?php

namespace SlimSkeleton\Console\Commands\Generator;

use SlimSkeleton\Console\Command;
use SlimSkeleton\Console\Traits\Generatable;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleGeneratorCommand extends Command
{
    use Generatable;

    protected $command = "make:command";

    protected $description = "Generate a console command class";    

    protected $customStubDirectory = __DIR__ . "/../../stubs";

    public function handle(InputInterface $input, OutputInterface $output)
    {
        $stub = $this->generateStub("command", [
            "DummyClass" => $this->argument("name"),
        ]);

        $target = $this->getRootDir() . "/app/App/Http/Console/Commands/" . $this->argument("name") . ".php";

        if(file_exists($target)) {
            return $this->error("Command already exists!", true);
        }

        file_put_contents($target, $stub);

        return $this->success("Console command generated!", true);    
    }

    protected function arguments(): array
    {
        return [
            ["name", InputArgument::REQUIRED, "The name of the command to generate."],
        ];
    }

    protected function options() : array
    {
        return [];
    }
}