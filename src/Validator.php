<?php

namespace Kata;

class Validator
{
    /**
     * @throws ValidatorException
     */
    public function validateAccountNumber(string $accountNumber): void
    {
        if (! $this->isValid($accountNumber)) {
            throw new ValidatorException('Invalid account number');
        }
    }

    public function isValid(string $accountNumber): bool
    {
        return ! str_contains($accountNumber, '?')
            && $this->getChecksum($accountNumber) === 0;
    }

    public function getChecksum(string $accountNumber): int
    {
        $checksum = 0;

        for ($i = 1; $i <= 9; $i++) {
            $checksum += $i * (int) $accountNumber[-$i];
        }

        return $checksum % 11;
    }
}
