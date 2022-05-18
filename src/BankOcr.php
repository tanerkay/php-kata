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
        $entries = $parser->getEntries($document);

        $lines = [];

        foreach ($entries as $entry) {
            $lines[] = $this->accountNumberStatus($entry);
        }

        // Simulate writing to a file (because we don't want to worry about file permissions)
        $this->output = join("\n", $lines);
    }

    /**
     * @throws ParserException
     */
    public function accountNumberStatus(string $entry): ?string
    {
        $parser = new Parser();

        $accountNumber = $parser->parse($entry);

        $status = null;

        // Check for illegal characters
        if (str_contains($accountNumber, '?')) {
            $status = 'ILL';
        }

        // Check for validation errors
        // in the real world, this validator instance would be injected
        elseif (! (new Validator())->isValid($accountNumber)) {
            $status = 'ERR';
        }

        if ($status === 'ILL' || $status === 'ERR') {
            try {
                $accountNumber = $this->guessAccountNumber($entry);
                $status = null;
            } catch (AmbiguousValueException $exception) {
                $options = "'" . join("', '", $exception->getMatches()) . "'";
                $status = "AMB [$options]";
            } catch (ValidatorException|ParserException) {
                $status = 'ILL';
            }
        }

        return $accountNumber . ($status ? " $status" : '');
    }

    /**
     * @throws AmbiguousValueException
     * @throws ParserException
     * @throws ValidatorException
     */
    public function guessAccountNumber(string $entry): ?string
    {
        $parser = new Parser();
        $validator = new Validator();

        $matches = [];

        for ($i = 0; $i < 83; $i++) {
            $part = $entry[$i];

            // Ignore the newline character
            if ($part === "\n") {
                continue;
            }

            $guesses = [];

            if ($part === ' ') {
                $guesses[] = substr_replace($entry, '_', $i, 1);
                $guesses[] = substr_replace($entry, '|', $i, 1);
            } else {
                $guesses[] = substr_replace($entry, ' ', $i, 1);
            }

            foreach ($guesses as $guess) {
                $guessedNumber = $parser->parse($guess);
                if ($validator->isValid($guessedNumber)) {
                    $matches[] = $guessedNumber;
                }
            }
        }

        if (count($matches) === 0) {
            throw new ValidatorException('No valid matches found.');
        } elseif (count($matches) >= 2) {
            throw new AmbiguousValueException('Multiple matches found.', $matches);
        }

        return $matches[0];
    }
}
