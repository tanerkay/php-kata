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

        $lines = [];

        foreach ($accountNumbers as $number) {
            $status = $this->accountNumberStatus($number);
            if ($status) {
                $number .= " $status";
            }
            $lines[] = $number;
        }

        // Simulate writing to a file (because we don't want to worry about file permissions)
        $this->output = join("\n", $lines);
    }

    public function accountNumberStatus(string $accountNumber): ?string
    {
        // Check for illegal characters
        if (str_contains($accountNumber, '?')) {
            return 'ILL';
        }

        // Check for validation errors
        try {
            // in the real world, this validator instance would be injected
            (new Validator())->validateAccountNumber($accountNumber);
        } catch (ValidatorException) {
            return 'ERR';
        }

        return null;
    }
}
