<?php

namespace Astromech;

use Astromech\DataFormatter\DataFormatterInterface;
use Astromech\LanguageConverter\LanguageConverterInterface;

/**
 * Data Processor
 *
 * @package Astromech
 */
class DataProcessor
{
    /**
     * @var DataFormatterInterface
     */
    private $formatter;

    /**
     * @var LanguageConverterInterface
     */
    private $converter;

    /**
     * Constructor
     *
     * @param DataFormatterInterface $formatter
     * @param LanguageConverterInterface $converter
     */
    public function __construct(
        DataFormatterInterface $formatter,
        LanguageConverterInterface $converter
    ) {
        $this->formatter = $formatter;
        $this->converter = $converter;
    }

    /**
     * Process captured data
     *
     * @param string $data
     *
     * @return array
     */
    public function process(string $data): array
    {
        $processedData = [];
        foreach ($this->formatter->format($data) as $key => $value) {
            $processedData[$key] = $this->converter->convert($value);
        }

        return $processedData;
    }
}
