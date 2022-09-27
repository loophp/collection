<?php

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;

$fibonacci = static fn (int $a = 0, int $b = 1): array => [$b, $b + $a];

$c = Collection::unfold($fibonacci)
    ->pluck(0)    // Get the first item of each result.
    ->limit(10);  // Limit the amount of results to 10.

print_r($c->all()); // [1, 1, 2, 3, 5, 8, 13, 21, 34, 55]
