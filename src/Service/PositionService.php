<?php

namespace App\Service;

use App\Domain\Position;
use App\Domain\PositionProvider;
use App\Service\Reader\Reader;

class PositionService implements PositionProvider
{
    /** @var Position[] */
    private $positions;

    public function __construct(Reader $reader)
    {
        $this->positions = $reader->all();
    }

    /**
     * Returns all defined positions
     * @return Position[]
     */
    public function all(): array
    {
        return $this->positions;
    }

    /**
     * @param $id
     * @return Position|null
     */
    public function get($id): ?Position
    {
        $position = array_reduce(
          $this->all(),
          static function ($carry, $pos) use ($id) {
              if ($pos->id() === $id) {
                  $carry = $pos;
              }

              return $carry;
          },
          null
        );

        return $position;
    }

    /**
     * Returns list of position keys
     * @return string[]
     */
    public function keys(): array
    {
        $keys = [];

        foreach ($this->positions as $position) {
            $keys[] = $position->id();
        }

        return $keys;
    }
}
