<?php

namespace Kata;

class Parser
{
    /**
     * @throws ParserException
     */
    public function parseDocument(string $document): array
    {
        $document = trim($document, "\n");

        $entries = str_split($document, 84);

        $results = [];

        foreach ($entries as $entry) {
            $results[] = $this->parse($entry);
        }

        return $results;
    }

    /**
     * @throws ParserException
     */
    public function parse(string $entry): string
    {
        if (! preg_match("/([|_ ]{27}\n?){3}\s*/", $entry)) {
            throw new ParserException('Invalid entry format.');
        }

        $lines = explode("\n", $entry);

        $result = '';

        for ($i = 0; $i < 9; $i++) {
            $segment = join('', array_map(fn ($line) => substr($line, 3 * $i, 3), $lines));
            $result .= $this->matchSegment($segment);
        }

        return $result;
    }

    /**
     * @throws ParserException
     */
    public function matchSegment(string $segment): string
    {
        $mapping = [
            '     |  |' => '1',
            ' _  _||_ ' => '2',
            ' _  _| _|' => '3',
            '   |_|  |' => '4',
            ' _ |_  _|' => '5',
            ' _ |_ |_|' => '6',
            ' _   |  |' => '7',
            ' _ |_||_|' => '8',
            ' _ |_| _|' => '9',
        ];

        if (! array_key_exists($segment, $mapping)) {
            throw new ParserException('Invalid segment in entry.');
        }

        return $mapping[$segment];
    }
}
