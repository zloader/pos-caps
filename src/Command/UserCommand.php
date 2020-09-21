<?php

namespace App\Command;

use App\Domain\PositionProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This class incapsulate 'user:*' command set behaviour for usage with Symfony console app
 *
 * @package App\Command
 */
class UserCommand extends Command
{
    protected const CMD_PREFIX = 'user';

    /** @var PositionProvider */
    private $positionService;

    use CommandValidator {
        hasCommandSuffix as private;
    }

    /**
     * UserCommand constructor.
     * @param PositionProvider $positionService
     */
    public function __construct(PositionProvider $positionService)
    {
        $this->positionService = $positionService;

        parent::__construct(self::CMD_PREFIX);
    }

    /**
     * @inheritdoc
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $command = $input->getArgument('command');

        // If given command hasn't position suffix the list of available suffixes will be shown
        if (!$this->hasCommandSuffix($command)) {
            $output->writeln(
              [
                "<info>====================</info>",
                "<info>Accessible suffixes</info>",
                "<info>====================</info>"
              ]
            );

            foreach ($this->positionService->all() as $position) {
                $output->writeln("{$position->id()}");
            }

            return Command::SUCCESS;
        }

        // Get position by given suffix and show capabilities
        [, $id] = explode(':', $command);
        $position = $this->positionService->get($id);
        $output->writeln(
          [
            "<info>===========================</info>",
            "<info>Capabilities of '{$id}'</info>",
            "<info>===========================</info>"
          ]
        );
        foreach ($position->capabilities() as $cap) {
            $output->writeln("- {$cap->description()}");
        }

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
          ->setHelp("Displays list of defined capabilities for requested position");
    }
}
