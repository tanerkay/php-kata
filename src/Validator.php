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
        $checksum = 0;

        for ($i = 1; $i <= 9; $i++) {
            $checksum += $i * $accountNumber[-$i];
        }

        return $checksum % 11;
    }
}
