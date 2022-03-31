<?php

namespace SlimSkeleton\Console\Traits;

trait Generatable
{
    protected $stubDirectory = __DIR__ . "/../stubs";

    public function generateStub($name, $replacements)
    {
        return str_replace(
            array_keys($replacements),
            $replacements,
            file_get_contents($this->stubDirectory . "/" . $name . ".stub")
        );
    }

    public function getAndMoveStub($path, $stubName, $fileName, $ext = ".php")
    {
        if(isset($this->stubDirectory)) {
            return false;
        }

        $stub = file_get_contents($this->stubDirectory . "/" . $stubName . ".stub");

        $stubTo = $path . "/" . $fileName . $ext;

        return file_put_contents($stubTo, $stub);
    }
}