<?php

namespace App\Service\Reader;

use App\Domain\Capability;

/**
 * This class gets 'capability' domain entity collection from PHP-array file
 *
 * @package App\Service\Reader
 */
class CapabilityReader extends FileReader
{
    /**
     * CapabilityReader constructor.
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->fill($this->loadFromFile($filePath));
    }

    /**
     * @inheritdoc
     */
    protected function apply($idx, $value): void
    {
        $this->collection [] = new Capability((string)$idx, (string)$value);
    }
}
