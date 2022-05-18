<?php

namespace Kata\Tests;

use Kata\BankOcr;
use PHPUnit\Framework\TestCase;

class BankOcrTest extends TestCase
{
    /**
     * @dataProvider documentProvider
     * @throws \Kata\BankOcrException
     * @throws \Kata\ParserException
     */
    public function testParseDocument(string $input, string $expectedOutput): void
    {
        $bankOcr = new BankOcr();

        $bankOcr->readAccountNumbers($input);

        $this->assertSame(
            $expectedOutput,
            $bankOcr->getOutput()
        );
    }

    public function documentProvider(): array
    {
        return [
            [
                <<<INPUT
                    _  _     _  _  _  _  _ 
                  | _| _||_||_ |_   ||_||_|
                  ||_  _|  | _||_|  ||_| _|
                
                    _  _     _  _  _  _  _ 
                  | _| _||_||_ |_   ||_||_|
                  ||_  _|  | _||_|  ||_||_|
                
                 _  _  _  _     _  _  _  _ 
                  ||_ |_||_||_|  | _||_||_ 
                  ||_| _||_|  |  ||_ |_| _|
                
                 _  _  _  _     _  _  _  _ 
                  ||_ |_||_||_|  |  ||_||_ 
                  ||_| _||_|  |  ||_ |_| _|
                
                    _  _  _  _  _  _     _ 
                |_||_|| || ||_   |  |  | _ 
                  | _||_||_||_|  |  |  | _|
                
                    _  _  _  _  _  _     _ 
                |_||_|| || ||_   |  |  ||_ 
                  | _||_||_||_|  |  |  | _|
                
                INPUT,
                <<<OUTPUT
                123456789
                123456789
                769847285
                769847285
                49006771? ILL
                490067715 AMB ['490067115', '490067719', '490867715']
                OUTPUT,
            ],
        ];
    }
}
