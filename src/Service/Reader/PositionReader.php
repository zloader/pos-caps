<?php


namespace App\Service\Reader;

use App\Domain\CapabilityProvider;
use App\Domain\Position;

/**
 * This class gets 'position' domain entity collection from PHP-array file
 *
 * @package App\Service\Reader
 */
class PositionReader extends FileReader
{
    /** @var CapabilityProvider */
    private $capabilitySource;

    /**
     * PositionReader constructor.
     * @param string             $filePath
     * @param CapabilityProvider $provider
     */
    public function __construct(string $filePath, CapabilityProvider $provider)
    {
        $this->capabilitySource = $provider;
        $this->fill($this->loadFromFile($filePath));
    }

    /**
     * @inheritDoc
     */
    protected function apply($idx, $element): void
    {
        $capabilities = [];

        foreach ($element as $id) {
            if ($capability = $this->capabilitySource->get($id)) {
                $capabilities [] = $capability;
            }
        }

        $this->collection [] = new Position($idx, $capabilities);
    }
}
