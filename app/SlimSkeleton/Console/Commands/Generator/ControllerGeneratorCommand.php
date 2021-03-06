<?php

namespace SlimSkeleton\Console\Commands\Generator;

use SlimSkeleton\Console\Command;
use SlimSkeleton\Console\Traits\Generatable;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ControllerGeneratorCommand extends Command
{
    use Generatable;

    protected $command = "make:controller";

    protected $description = "Generate a new controller class";    

    protected $customStubDirectory = __DIR__ . "/../../stubs";

    public function handle(InputInterface $input, OutputInterface $output)
    {
        $controllerBase = $this->getRootDir() . "/app/" . $this->option("namespace") . "/Http/Controllers";
        $path = $controllerBase . "/";
        $namespace = $this->option("namespace") . "\\Http\\Controllers";

        $fileParts = explode("\\", trim($this->argument("name")));

        $fileName = array_pop($fileParts);

        $cleanPath = implode("/", $fileParts);

        if (count($fileParts) >= 1) {
            $path = $path . $cleanPath;

            $namespace = $namespace . "\\" . str_replace("/", "\\", $cleanPath);

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
        }

        $target = $path . "/" . $fileName . ".php";

        if (file_exists($target)) {
            return $this->error("Controller already exists!", true);
        }

        if($this->option("view")) {
            $stub = $this->generateStub("controller-view", [
                "DummyClass" => $fileName,
                "DummyNamespace" => $namespace,
                "DummyView" => $this->cleanPathName($this->option("view")),
            ]);
        } else {
            $stub = $this->generateStub("controller", [
                "DummyClass" => $fileName,
                "DummyNamespace" => $namespace,
            ]);
        }

        file_put_contents($target, $stub);

        if($this->option("view")) {
            $this->generateView($this->option("view"));
        }

        return $this->success("Controller generated!", true); 
    }

    private function generateView($name) 
    {
        $viewBase = __DIR__ . "/../../../../../resources/views";
        $path = $viewBase . "/";

        $fileParts = explode("/", trim($name));

        $fileName = array_pop($fileParts);

        $cleanPath = implode("/", $fileParts);

        if (count($fileParts) >= 1) {
            $path = $path . $cleanPath;

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
        }

        $fileName = strtolower($fileName);

        $target = $path . "/" . $fileName . ".twig";

        if (file_exists($target)) {
            return $this->error("View already exists in base resources/views directory!", true);
        }

        file_put_contents($target, $this->generateStub("view", []));

        return $this->success("View has been generated!", true);
    }
    
    private function cleanPathName($name) 
    {
        return ltrim($name, "/");
    }

    protected function arguments(): array
    {
        return [
            ["name", InputArgument::REQUIRED, "The name of the controller to generate"]
        ];
    }

    protected function options() : array
    {
        return [
            ["view", "t", InputOption::VALUE_REQUIRED, "Generate a TWIG view with the provided name", null],
            ["namespace", "ns", InputOption::VALUE_REQUIRED, "Define a namespace to use for generating controllers.", "App"]
        ];
    }
}