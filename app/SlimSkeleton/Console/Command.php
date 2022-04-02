<?php

namespace SlimSkeleton\Console;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Command extends SymfonyCommand
{
    private $input, $output;

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();

        $this->container = $container;
    }

    protected function configure()
    {
        $this->setName($this->command)->setDescription($this->description);

        $this->addArguments();
        $this->addOptions();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        return $this->handle($input, $output);
    }

    protected function argument($name)
    {
        return $this->input->getArgument($name);
    }

    protected function option($name)
    {
        return $this->input->getOption($name);
    }

    protected function addArguments()
    {
        foreach($this->arguments() as $argument) {
            $this->addArgument($argument[0], $argument[1], $argument[2]);
        }
    }

    protected function addOptions()
    {
        foreach ($this->options() as $option) {
            $this->addOption($option[0], $option[1], $option[2], $option[3], $option[4]);
        }
    }

    protected function success($value, $end = true)
    {
        $this->output->writeln("<info>" . $value . "</info>");

        if($end) {
            return SymfonyCommand::SUCCESS;
        }
    }

    protected function write($value, $end = true)
    {
        $this->output->writeln($value);

        if($end) {
            return SymfonyCommand::SUCCESS;
        }
    }

    protected function warn($value, $end = true)
    {
        $this->output->writeln("<comment>" . $value . "</comment>");

        if($end) {
            return SymfonyCommand::SUCCESS;
        }
    }

    protected function info($value, $end = true)
    {
        $this->output->writeln("<question>" . $value . "</question>");

        if($end) {
            return SymfonyCommand::SUCCESS;
        }
    }

    protected function error($value, $end = true)
    {
        $this->output->writeln("<error>" . $value . "</error>");

        if($end) {
            return SymfonyCommand::FAILURE;
        }
    }

    public abstract function handle(InputInterface $input, OutputInterface $output);
    protected abstract function options(): array;
    protected abstract function arguments(): array;
}