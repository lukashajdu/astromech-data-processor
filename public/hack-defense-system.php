<?php

require __DIR__ . '/../vendor/autoload.php';

$dataProcessor = new \Astromech\DataProcessor(
    new \Astromech\DataFormatter\JsonFormatter(),
    new \Astromech\LanguageConverter\DroidspeakToGalacticConverter()
);

echo <<<TXT
===============================
== CAPTURED TRANSACTION DATA ==
===============================\n
TXT;

try {
    foreach ($dataProcessor->process(file_get_contents('php://input')) as $key => $value) {
        echo sprintf("%s: %s\n", $key, $value);
    }
} catch (\Astromech\DataFormatter\FormatterException $exception) {
    echo sprintf("The captured data is damaged. %s\n", $exception->getMessage());
} catch (\Astromech\LanguageConverter\ConverterException $exception) {
    echo sprintf("Unable to convert the captured data. %s\n", $exception->getMessage());
}

echo <<<TXT
===============================
==     END OF TRANSACTION    ==
===============================\n
TXT;
