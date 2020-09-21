<?php

namespace App\Service;

use App\Domain\Capability;
use App\Domain\CapabilityProvider;
use App\Service\Reader\Reader;

class CapabilityService implements CapabilityProvider
{
    /** @var Capability[] */
    private $capabilities;

    public function __construct(Reader $reader)
    {
        $this->capabilities = $reader->all();
    }

    /**
     * Returns all defined capabilities
     * @return Capability[]
     */
    public function all(): array
    {
        return $this->capabilities;
    }

    /**
     * @param $id
     * @return Capability|null
     */
    public function get($id): ?Capability
    {
        $cap = array_reduce(
          $this->capabilities,
          static function ($carry, $cap) use ($id) {
              if ($cap->id() === $id) {
                  $carry = $cap;
              }

              return $carry;
          },
          null
        );

        return $cap;
    }

    /**
     * Returns list of capability keys
     * @return string[]
     */
    public function keys(): array
    {
        $keys = [];

        foreach ($this->capabilities as $capability) {
            $keys[] = $capability->id();
        }

        return $keys;
    }
}
