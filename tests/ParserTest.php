<?php

namespace Kata\Tests;

use Kata\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    /**
     * @dataProvider entriesProvider
     * @throws \Kata\ParserException
     */
    public function testValidSums(string $entry, string $expectedResult): void
    {
        $this->assertSame(
            $expectedResult,
            (new Parser())->parse($entry)
        );
    }

    public function entriesProvider(): array
    {
        return [
            [
                <<<ENTRY
                    _  _     _  _  _  _  _ 
                  | _| _||_||_ |_   ||_||_|
                  ||_  _|  | _||_|  ||_| _|
                
                ENTRY,
                '123456789'
            ]
        ];
    }
}
