<?php

namespace App\Command;

use App\Service\CapabilityService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CapabilityCommand
 * @package App\Command
 */
class CapabilityCommand extends Command
{
    /** @var CapabilityService */
    private $capsService;

    public function __construct(CapabilityService $caps)
    {
        $this->capsService = $caps;

        parent::__construct('caps:list');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(
          [
            '<info>Defined Capabilities</info>',
            '<info>====================</info>'
          ]
        );

        foreach ($this->capsService->all() as $cap) {
            $output->writeln((string)$cap);
        }

        return Command::SUCCESS;
    }

    protected function configure()
    {
        $this
          ->setDescription("Displays list of available capabilities")
          ->setHelp("This command displays capability keys that can be useful to other commands")
          ->setAliases(['caps:all']);
    }
}
