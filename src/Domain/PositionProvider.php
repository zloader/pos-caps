<?php

namespace App\Domain;

/**
 * Interface PositionProvider
 * @package App\Provider
 */
interface PositionProvider extends GenericProvider
{
    /**
     * Returns capability
     * @param $id
     * @return Position|null
     */
    public function get($id): ?Position;
}
