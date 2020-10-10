<?php

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;

$collection = Collection::fromString(file_get_contents('http://loripsum.net/api'))
    // Filter out some characters.
    ->filter(
        static function ($item, $key): bool {
            return (bool) preg_match('/^[a-zA-Z]+$/', $item);
        }
    )
    // Lowercase each character.
    ->map(static function (string $letter): string {
        return mb_strtolower($letter);
    })
    // Run the frequency tool.
    ->frequency()
    // Flip keys and values.
    ->flip()
    // Sort values.
    ->sort()
    // Convert to array.
    ->all();

print_r($collection);
