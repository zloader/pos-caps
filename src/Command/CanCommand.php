<?php

namespace App\Command;

use App\Domain\Capability;
use App\Domain\CapabilityProvider;
use App\Domain\Position;
use App\Domain\PositionProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This class incapsulate 'can:*' command set behaviour for usage with Symfony console app
 *
 * @package App\Command
 */
class CanCommand extends Command
{
    protected const CMD_PREFIX = 'can';

    /** @var CapabilityProvider */
    private $capabilityService;

    /** @var PositionProvider */
    private $positionService;

    use CommandValidator {
        hasCommandSuffix as private;
    }

    /**
     * CanCommand constructor.
     * @param PositionProvider   $positionService
     * @param CapabilityProvider $capabilityService
     */
    public function __construct(PositionProvider $positionService, CapabilityProvider $capabilityService)
    {
        $this->positionService = $positionService;
        $this->capabilityService = $capabilityService;

        parent::__construct(self::CMD_PREFIX);
    }

    /**
     * @inheritdoc
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $input->getArgument('command');
        $requestedCapability = $input->getArgument('capability');

        // If given command hasn't position suffix request will be solved over positions set
        if (!$this->hasCommandSuffix($command)) {
            $output->writeln(
              [
                "<info>====================</info>",
                "<info>Who can {$requestedCapability}</info>",
                "<info>====================</info>"
              ]
            );

            foreach ($this->positionService->all() as $position) {
                $capability = $this->capabilityService->get($requestedCapability);

                $output->writeln(
                  "Can '{$position->id()}' {$requestedCapability}: {$this->canPositionToString($position, $capability)}"
                );
            }

            return Command::SUCCESS;
        }

        // Get position by given suffix and show has position requested capability
        [, $id] = explode(':', $command);
        $position = $this->positionService->get($id);
        $capability = $this->capabilityService->get($requestedCapability);

        $output->writeln(
          "Can '{$position->id()}' {$requestedCapability}: {$this->canPositionToString($position, $capability)}"
        );

        return Command::SUCCESS;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        // Make command aliases array based on the existed positions
        $aliases = array_map(
          static function ($key) {
              return self::CMD_PREFIX . ":{$key}";
          },
          $this->positionService->keys()
        );

        $this
          ->setAliases($aliases)
          ->setDescription("Show position capabilities")
          ->setHelp("Displays list of defined capabilities for requested position")
          ->addArgument('capability', InputArgument::REQUIRED, 'Position capability');
    }

    /**
     * Check if the position can make capability
     * @param Position   $position
     * @param Capability $capability
     * @return string
     * @todo Move to somewhere, there is not good place for this method
     */
    private function canPositionToString(Position $position, Capability $capability): string
    {
        return $position->can($capability) ? 'true' : 'false';
    }
}
