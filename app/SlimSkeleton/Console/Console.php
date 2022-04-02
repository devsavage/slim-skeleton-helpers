<?php

namespace SlimSkeleton\Console;

use Slim\App;
use SlimSkeleton\Console\KernelInterface;
use Symfony\Component\Console\Application;

class Console extends Application
{
    protected $app, $rootDir;

    public function __construct(App $app, $version, $rootDir)
    {
        parent::__construct("Slim Skeleton Base", $version);

        $this->app = $app;
        $this->rootDir = $rootDir;
    }

    public function boot(KernelInterface $kernel) 
    {
        foreach($kernel->getCommands() as $command) {
            $this->add(new $command($this->getApp()->getContainer(), $this->getRootDir()));
        }
    }

    private function getApp()
    {
        return $this->app;
    }

    public function getRootDir()
    {
        return $this->rootDir;
    }
}