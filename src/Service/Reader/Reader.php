<?php

namespace App\Service\Reader;

/**
 * Interface Reader
 * @package App\Service\Reader
 */
interface Reader
{
    /**
     * Returns all defined items
     * @return array
     */
    public function all(): array;
}
