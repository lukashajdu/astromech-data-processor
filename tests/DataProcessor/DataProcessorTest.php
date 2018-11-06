<?php

namespace Astromech;

use Astromech\DataFormatter\DataFormatterInterface;
use Astromech\LanguageConverter\LanguageConverterInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * Data Processor Test
 *
 * @package Astromech\DataProcessor
 */
class DataProcessorTest extends TestCase
{
    /**
     * @var DataFormatterInterface|ObjectProphecy
     */
    private $formatter;

    /**
     * @var LanguageConverterInterface|ObjectProphecy
     */
    private $converter;

    public function setUp()
    {
        $this->formatter = $this->prophesize(DataFormatterInterface::class);
        $this->converter = $this->prophesize(LanguageConverterInterface::class);
    }

    public function test_process_returns_empty_array_for_no_data()
    {
        $this->formatter->format(Argument::exact('[]'))->willReturn([]);

        $processor = new DataProcessor(
            $this->formatter->reveal(),
            $this->converter->reveal()
        );

        $this->assertEquals([], $processor->process('[]'));
    }

    public function test_process_returns_processed_and_converted_data()
    {
        $location = '01000100 01010011 00101101 00110001';
        $data = json_encode(['location' => $location]);

        $this->formatter->format(Argument::exact($data))->willReturn([
            'location' => $location
        ]);
        $this->converter->convert(Argument::exact($location))->willReturn('DS-1');

        $processor = new DataProcessor(
            $this->formatter->reveal(),
            $this->converter->reveal()
        );

        $this->assertEquals(['location' => 'DS-1'], $processor->process($data));
    }
}
