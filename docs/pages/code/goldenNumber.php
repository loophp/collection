<?php

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;

// Golden ratio: https://en.wikipedia.org/wiki/Golden_ratio
$goldenNumberGenerator = static fn ($a = 0): array => [($a + 1) ** .5];

$goldenNumber = Collection::unfold($goldenNumberGenerator)
    ->limit(10)
    ->unwrap()
    ->last();

var_dump($goldenNumber->current()); // 1.6180165422314876
