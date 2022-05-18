<?php

namespace Kata;

class Parser
{
    /**
     * @throws ParserException
     */
    public function getEntries(string $document): array
    {
        $document = trim($document, "\n");

        return str_split($document, 85);
    }

    /**
     * @throws ParserException
     */
    public function parse(string $entry): string
    {
        if (! preg_match("/([|_ ]{27}\n?){3}\s*/", $entry)) {
            throw new ParserException('Invalid entry format.');
        }

        // Get non-empty lines in entry as array
        $lines = array_filter(explode("\n", $entry));

        $result = '';

        for ($i = 0; $i < 9; $i++) {
            // Collate the horizontal part of each line to form a segment
            $segment = join("\n", array_map(fn ($line) => substr($line, 3 * $i, 3), $lines));
            try {
                $result .= $this->matchSegment($segment);
            } catch (ParserException) {
                $result .= '?';
            }
        }

        return $result;
    }

    /**
     * @throws ParserException
     */
    public function matchSegment(string $segment): string
    {
        $mapping = [
            <<<segment
             _ 
            | |
            |_|
            segment => '0',
            <<<segment
               
              |
              |
            segment => '1',
            <<<segment
             _ 
             _|
            |_ 
            segment => '2',
            <<<segment
             _ 
             _|
             _|
            segment => '3',
            <<<segment
               
            |_|
              |
            segment => '4',
            <<<segment
             _ 
            |_ 
             _|
            segment => '5',
            <<<segment
             _ 
            |_ 
            |_|
            segment => '6',
            <<<segment
             _ 
              |
              |
            segment => '7',
            <<<segment
             _ 
            |_|
            |_|
            segment => '8',
            <<<segment
             _ 
            |_|
             _|
            segment => '9',
        ];

        if (! array_key_exists($segment, $mapping)) {
            throw new ParserException('Invalid segment in entry.');
        }

        return $mapping[$segment];
    }
}
