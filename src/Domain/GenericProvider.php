<?php

namespace App\Domain;

/**
 * Interface GenericProvider
 * @package App\Domain
 */
interface GenericProvider
{
    /**
     * Returns capabilities list
     * @return array
     */
    public function all(): array;

    /**
     * Returns identifiers list of the defined capabilities
     * @return array
     */
    public function keys(): array;
}
