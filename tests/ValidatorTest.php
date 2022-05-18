<?php

namespace Kata\Tests;

use Kata\Parser;
use Kata\Validator;
use Kata\ValidatorException;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    /**
     * @dataProvider accountNumberProvider
     * @throws \Kata\ParserException
     */
    public function testAccountNumbers(string $accountNumber, bool $isValid): void
    {
        if ($isValid) {
            $this->expectException(ValidatorException::class);
        } else {
            $this->expectNotToPerformAssertions();
        }

        (new Validator())->validateAccountNumber($accountNumber);
    }

    public function accountNumberProvider(): array
    {
        return [
            ['123456789', true],
            ['123456788', false],
        ];
    }
}
