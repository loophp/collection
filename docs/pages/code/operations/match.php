<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

// Example 1 -> match found
$result = Collection::fromIterable(range(1, 100))
    ->match(static fn (int $value): bool => 10 > $value); // true

// Example 2 -> match not found
$result = Collection::fromIterable(range(1, 100))
    ->match(static fn (int $value): bool => 314 < $value); // false

// Example 3 -> match found
$input = [
    'Ningbo (CN)',
    'California (US)',
    'Brussels (EU)',
    'New York (US)',
];

$pattern = '/\(EU\)$/';

$result = Collection::fromIterable($input)
    ->match(static fn (string $value): bool => (bool) preg_match($pattern, $value)); // true

// Example 4 -> custom matcher
$result = Collection::fromIterable(range(1, 10))
    ->match(static fn (int $value): bool => 5 !== $value, static fn (): bool => false); // true
