<?php

namespace App\Service\Reader;

/**
 * Base class for getting domain entities from PHP-array file
 *
 * @package App\Service\Reader
 */
abstract class FileReader implements Reader
{
    /** @var array */
    protected $collection;

    /**
     * Returns all loaded entities
     * @return array
     */
    public function all(): array
    {
        return $this->collection;
    }

    /**
     * Apply loaded array element to collection as domain entity instance
     * @param $idx
     * @param $element
     */
    abstract protected function apply($idx, $element): void;

    /**
     * Filling the entities collection
     * @param array $elements
     */
    protected function fill(array $elements): void
    {
        foreach ($elements as $idx => $element) {
            $this->apply($idx, $element);
        }
    }

    /**
     * Does requested file exists and accessible for reading
     * @param string $filePath
     * @return bool
     */
    protected function isFilePathValid(string $filePath): bool
    {
        return file_exists($filePath) || !is_dir($filePath) || is_readable($filePath);
    }

    /**
     * Returns array from file
     * @param string $filePath
     * @return array
     */
    protected function loadFromFile(string $filePath): array
    {
        if (!$this->isFilePathValid($filePath)) {
            throw new \InvalidArgumentException(__CLASS__ . ": positions source file isn't accessible.");
        }

        return require $filePath;
    }
}
