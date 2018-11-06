<?php

namespace Astromech\DataFormatter;

/**
 * JSON Formatter
 *
 * @package Astromech\DataFormatter
 */
class JsonFormatter implements DataFormatterInterface
{
    public function format(string $data): array
    {
        return $this->convertJson($data);
    }

    public function convertJson(string $jsonString): array
    {
        $data = json_decode($jsonString, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $data;
        }

        throw new FormatterException('Unable to process data.');
    }
}
