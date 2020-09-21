<?php

namespace App\Domain;

class Capability
{
    /** @var string */
    private $description;
    /** @var mixed */
    private $id;

    /**
     * Capability constructor.
     * @param        $id
     * @param string $description
     */
    public function __construct($id, string $description)
    {
        $this->id = strtolower($id);
        $this->description = $description;
    }

    /**
     * Returns capability description
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * Returns result of capability comparison
     * @param Capability $capability
     * @return bool
     */
    public function equal(Capability $capability): bool
    {
        return $this->id === $capability->id();
    }

    /**
     * Returns capability ID
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->id()} - Owner of the '{$this->id()}' capability can {$this->description()}";
    }
}
