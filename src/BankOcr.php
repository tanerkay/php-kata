<?php

namespace Kata;

class BankOcr
{
    private string $output;

    /**
     * @throws BankOcrException
     */
    public function getOutput(): string
    {
        if (! isset($this->output)) {
            throw new BankOcrException('No document parsed yet.');
        }

        return $this->output;
    }

    /**
     * @throws ParserException
     */
    public function readAccountNumbers(string $document): void
    {
        $parser = new Parser();

        // Simulate reading from a file
        $accountNumbers = $parser->parseDocument($document);

        // Simulate writing to a file (because we don't want to worry about file permissions)
        $this->output = join("\n", $accountNumbers);
    }
}
