<?php

namespace Astromech\LanguageConverter;

/**
 * Language Converter Interface
 *
 * @package Astromech\LanguageConverter
 */
interface LanguageConverterInterface
{
    /**
     * Convert data to specific language
     *
     * @param string $message
     *
     * @return string
     * @throws ConverterException
     */
    public function convert(string $message): string;
}
