<?php

require __DIR__ . '/../vendor/autoload.php';

$dataProcessor = new \Astromech\DataProcessor(
    new \Astromech\DataFormatter\JsonFormatter(),
    new \Astromech\LanguageConverter\DroidspeakToGalacticConverter()
);

try {
    $processedData = $dataProcessor->process(file_get_contents('php://input'));
    print_r($processedData);
} catch (\Astromech\DataFormatter\FormatterException $exception) {
    echo $exception->getMessage();
} catch (\Astromech\LanguageConverter\ConverterException $exception) {
    echo $exception->getMessage();
}
