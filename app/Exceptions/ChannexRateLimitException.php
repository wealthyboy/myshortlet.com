<?php

namespace App\Exceptions;

use RuntimeException;

class ChannexRateLimitException extends RuntimeException
{
    protected int $retryAfter;

    public function __construct(int $retryAfter)
    {
        parent::__construct('Channex ARI rate limit reached.');
        $this->retryAfter = max(1, $retryAfter);
    }

    public function retryAfter(): int
    {
        return $this->retryAfter;
    }
}
