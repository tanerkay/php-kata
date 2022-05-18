<?php

namespace Kata;

class Validator
{
    /**
     * @throws ValidatorException
     */
    public function validateAccountNumber(string $accountNumber): void
    {
        if ($this->getChecksum($accountNumber) !== 0) {
            throw new ValidatorException('Invalid account number');
        }
    }

    public function getChecksum(string $accountNumber): int
    {
        return array_sum(str_split($accountNumber)) % 11;
    }
}
