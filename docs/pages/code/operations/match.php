<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

// Example 1
$matcher = static function (int $value): bool {
    return 10 > $value;
};

$collection = Collection::fromIterable(range(1, 100))
    ->match($matcher); // true

// Example 2
$matcher = static function (int $value): bool {
    return 314 < $value;
};

$collection = Collection::fromIterable(range(1, 100))
    ->match($matcher); // false

// Example 3
$input = [
    'Ningbo (CN)',
    'California (US)',
    'Brussels (EU)',
    'New York (US)',
];

$pattern = '/\(EU\)$/';

$colletion = Collection::fromIterable($input)
    ->match(
        static fn (string $value): bool => preg_match($pattern, $value)
    ); // true
