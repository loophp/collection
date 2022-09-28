<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;
use loophp\collection\Operation\Span;

include __DIR__ . '/../../../../vendor/autoload.php';

$input = range(1, 10);

// Example 1 -> Retrieve the left and right groups
[$first, $last] = Collection::fromIterable($input)
    ->span(static fn ($x): bool => 4 > $x)
    ->all();

print_r($first->all()); // [1, 2, 3]
print_r($last->all());  // [4, 5, 6, 7, 8, 9, 10]

// Example 2 -> Retrieve the second group only
$last = Collection::fromIterable($input)
    ->span(static fn ($x): bool => 4 > $x)
    ->last();

print_r($last->all()); // [4, 5, 6, 7, 8, 9, 10]

// Example 3 -> Use Span operation separately
[$left] = iterator_to_array(Span::of()(static fn ($x): bool => 4 > $x)($input));

print_r(iterator_to_array($left)); // [1, 2, 3]
