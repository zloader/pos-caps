<?php

namespace App\Domain;

class Position
{
    /** @var mixed */
    protected $id;

    /** @var Capability[] */
    protected $capabilities;

    public function __construct($id, array $capabilities)
    {
        $this->id = $id;
        $this->capabilities = $capabilities;
    }

    /**
     * Returns position ID
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return Capability[]
     */
    public function capabilities(): array
    {
        return $this->capabilities;
    }

    /**
     * @param Capability $capability
     * @return bool
     */
    public function can(Capability $capability): bool
    {
        $caps = array_filter(
          $this->capabilities,
          static function ($cap) use ($capability) {
              return $cap->equal($capability);
          }
        );

        return (bool)$caps;
    }
}
