<?php

namespace App\Domain;

/**
 * Interface CapabilityProvider
 * @package App\Provider
 */
interface CapabilityProvider extends GenericProvider
{
    /**
     * Returns capability
     * @param $id
     * @return Capability|null
     */
    public function get($id): ?Capability;
}
