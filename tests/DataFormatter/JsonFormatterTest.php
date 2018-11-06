<?php

namespace Astromech\DataFormatter;

use PHPUnit\Framework\TestCase;

/**
 * JSON Formatter Test
 *
 * @package Astromech\DataFormatter
 */
class JsonFormatterTest extends TestCase
{
    public function test_format_returns_data_formatted_to_array()
    {
        $this->assertInternalType('array', (new JsonFormatter())->format('[]'));
        $this->assertInternalType('array', (new JsonFormatter())->format('{}'));
    }

    public function test_convertJson_throws_FormatterException_for_invalid_data()
    {
        $this->expectException(FormatterException::class);
        $this->expectExceptionMessage('Unable to process data');

        (new JsonFormatter())->convertJson('Leia');
    }

    public function test_convertJson_converts_JSON_string_into_associative_array()
    {
        $formatter = new JsonFormatter();
        $this->assertEquals(
            ['location' => 'DS-1'],
            $formatter->convertJson('{"location": "DS-1"}')
        );
        $this->assertEquals(
            ['Leia', 'Chewbacca', 'C-3PO'],
            $formatter->convertJson('["Leia", "Chewbacca", "C-3PO"]')
        );
    }

    public function test_format_formats_JSON_data()
    {
        $this->assertEquals(
            ['message' => '01100011 01001100'],
            (new JsonFormatter())->format('{"message": "01100011 01001100"}')
        );
    }
}
