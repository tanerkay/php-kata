<?php

namespace Kata;

class AmbiguousValueException extends \Exception
{
    private array $matches;

    public function __construct(
        string $message,
        array $matches = [],
        int $code = 0,
        \Throwable|null $previous = null
    ) {
        sort($matches);
        $this->matches = $matches;

        parent::__construct($message, $code, $previous);
    }

    public function getMatches(): array
    {
        return $this->matches;
    }
}
