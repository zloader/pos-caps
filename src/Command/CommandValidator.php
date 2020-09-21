<?php

namespace App\Command;

trait CommandValidator
{
    /**
     * @param string $command
     * @return bool
     */
    public function hasCommandSuffix(string $command): bool
    {
        return (bool)preg_match('/\A^\w+(:\w+)$\z/im', $command);
    }
}
