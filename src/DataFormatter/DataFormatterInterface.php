<?php

namespace Astromech\DataFormatter;

/**
 * Data Formatter Interface
 *
 * @package Astromech\DataFormatter
 */
interface DataFormatterInterface
{
    /**
     * Format data
     *
     * @param string $data
     *
     * @return array
     * @throws FormatterException
     */
    public function format(string $data): array;
}
