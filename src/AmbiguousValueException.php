<?php

namespace Kata;

class AmbiguousValueException extends \Exception
{
    public function __construct(
        string $message,
        private readonly array $matches,
        int $code = 0,
        \Throwable|null $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getMatches(): array
    {
        return $this->matches;
    }
}
