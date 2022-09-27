<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

use const INF;

include __DIR__ . '/../../../../vendor/autoload.php';

// Example 1 -> A list of Naturals from 1 to Infinity (use `limit` to keep only a set of them)
Collection::unfold(static fn (int $n): array => [$n + 1], 1)
    ->unwrap()
    ->all(); // [1, 2, 3, 4, ...]

// Example 2 -> fibonacci sequence
Collection::unfold(static fn (int $a = 0, int $b = 1): array => [$b, $a + $b])
    ->pluck(0)
    ->limit(10)
    ->all(); // [1, 1, 2, 3, 5, 8, 13, 21, 34, 55]

// Example 3 -> infinite range, similar to the `range` operation
$even = Collection::unfold(static fn ($carry): array => [$carry + 2], -2)->unwrap();
$odd = Collection::unfold(static fn ($carry): array => [$carry + 2], -1)->unwrap();

// Is the same as
$even = Collection::range(0, INF, 2);
$odd = Collection::range(1, INF, 2);
