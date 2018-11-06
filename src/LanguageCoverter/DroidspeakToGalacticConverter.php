<?php

namespace Astromech\LanguageConverter;

/**
 * Droidspeak To Galactic Converter
 *
 * @package Astromech\LanguageConverter
 */
class DroidspeakToGalacticConverter implements LanguageConverterInterface
{
    const ASCII_CHAR_LENGTH = 8;

    public function convert(string $message): string
    {
        return $this->convertBinaryMessage($message);
    }

    public function convertBinaryMessage(string $binaryMessage): string
    {
        if (!$this->isBinaryMessageValid($binaryMessage)) {
            throw new ConverterException('The message has not correct Droidspeak format.');
        }

        $convertedString = [];
        $binaryMessage = explode(' ', $this->formatBinaryMessage($binaryMessage));
        for ($index = 0; count($binaryMessage) > $index; $index++) {
            $convertedString[] = chr(bindec($binaryMessage[$index]));
        }

        return implode($convertedString);
    }

    public function formatBinaryMessage(string $binaryMessage): string
    {
        $binaryMessage = str_replace([' ', "\n"], '', $binaryMessage);
        if (strlen($binaryMessage) % self::ASCII_CHAR_LENGTH !== 0) {
            throw new ConverterException('Message data lost at the transaction. '
                . 'Droidspeak message contains an invalid number of characters.');
        }

        return trim(chunk_split($binaryMessage, self::ASCII_CHAR_LENGTH, ' '));
    }

    public function isBinaryMessageValid(string $binaryMessage): bool
    {
        return preg_match('/^([01]{8}\s?)+$/', $binaryMessage, $matches) === 1
            ? true
            : false;
    }
}
