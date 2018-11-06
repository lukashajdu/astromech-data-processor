<?php

namespace Astromech\Tests\LanguageConverter;

use Astromech\LanguageConverter\ConverterException;
use Astromech\LanguageConverter\DroidspeakToGalacticConverter;
use PHPUnit\Framework\TestCase;

/**
 * Droidspeak To Galactic Converter Test
 *
 * @package Astromech\LanguageConverter
 */
class DroidspeakToGalacticConverterTest extends TestCase
{
    public function test_isBinaryMessageValid_returns_true_for_string_containing_binary_characters()
    {
        $converter = new DroidspeakToGalacticConverter();
        $this->assertTrue($converter->isBinaryMessageValid('10001010'));
        $this->assertTrue($converter->isBinaryMessageValid('10001001 01010111'));
    }

    public function test_isBinaryMessageValid_returns_false_for_string_containing_non_binary_characters()
    {
        $converter = new DroidspeakToGalacticConverter();
        $this->assertFalse($converter->isBinaryMessageValid('11002104410'));
        $this->assertFalse($converter->isBinaryMessageValid('message'));
    }

    public function test_formatBinaryMessage_throws_ConverterException_if_the_string_does_not_contain_correct_length()
    {
        $this->expectException(ConverterException::class);
        $this->expectExceptionMessage('Message data lost at transaction. '
            . 'Droidspeak message contains invalid number of characters.');

        (new DroidspeakToGalacticConverter())->formatBinaryMessage('100');
    }

    public function test_formatBinaryMessage_returns_digits_grouped_by_eight()
    {
        $converter = new DroidspeakToGalacticConverter();
        $this->assertEquals('10110010', $converter->formatBinaryMessage('10110010'));
        $this->assertEquals('10110010 00110101', $converter->formatBinaryMessage('10110010 00110101'));
        $this->assertEquals('10110010 00110101', $converter->formatBinaryMessage('1011001000110101'));
    }

    public function test_convertBinaryMessage_returns_string()
    {
        $converter = new DroidspeakToGalacticConverter();
        $this->assertInternalType('string', $converter->convertBinaryMessage('00110100'));
    }

    public function test_convertBinaryMessage_throws_ConverterException_for_invalid_message()
    {
        $converter = new DroidspeakToGalacticConverter();

        $this->expectException(ConverterException::class);
        $this->expectExceptionMessage('Message has not correct Droidspeak format.');

        $converter->convertBinaryMessage('12345678');
    }

    public function test_convertBinaryMessage_returns_converted_message()
    {
        $converter = new DroidspeakToGalacticConverter();
        $this->assertEquals(
            'Cell 2187',
            $converter->convertBinaryMessage(
                '01000011 01100101 01101100 01101100 00100000 00110010 00110001 00111000 00110111'
            )
        );

        $this->assertEquals(
            'Detention Block AA-23',
            $converter->convertBinaryMessage(
                '01000100 01100101 01110100 01100101 01101110 01110100 01101001 01101111 01101110 '
                . '00100000 01000010 01101100 01101111 01100011 01101011 00100000 01000001 01000001'
                . '00101101 00110010 00110011'
            )
        );
    }

    public function test_getConvertedMessage_returns_string()
    {
        $this->assertInternalType(
            'string',
            (new DroidspeakToGalacticConverter())->convert('10100011')
        );
    }

    public function test_getConvertedMessage_returns_converted_message()
    {
        $converter = new DroidspeakToGalacticConverter();
        $this->assertEquals('R2D2', $converter->convert('01010010 00110010 01000100 00110010'));
    }
}
