<?php

namespace SlimSkeleton\Console\Traits;

trait Generatable
{
    public $stubDirectory = null;

    private function getStubDirectory()
    {
        return $this->stubDirectory;
    }

    public function generateStub($name, $replacements)
    {
        return str_replace(
            array_keys($replacements),
            $replacements,
            file_get_contents($this->getStubDirectory() . "/" . $name . ".stub")
        );
    }

    public function getAndMoveStub($path, $stubName, $fileName, $ext = ".php")
    {
        if(!$this->getStubDirectory()) {
            return false;
        }

        $stub = file_get_contents($this->getStubDirectory() . "/" . $stubName . ".stub");

        $stubTo = $path . "/" . $fileName . $ext;

        return file_put_contents($stubTo, $stub);
    }
}