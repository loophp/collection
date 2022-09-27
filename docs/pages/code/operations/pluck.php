<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

// Example 1 -> numeric keys
$fibonacci = static fn ($a = 0, $b = 1): array => [$b, $a + $b];
$collection = Collection::unfold($fibonacci)
    ->limit(6)
    ->pluck(0); // [1, 1, 2, 3, 5, 8]

// Example 2 -> basic string keys
$input = [
    ['foo' => 'A', 'bar' => 'B'],
    ['foo' => 'C', 'bar' => 'D'],
];
$collection = Collection::fromIterable($input)
    ->pluck('foo');  // ['A', 'C']

// Example 3 -> nested keys and values
$input = [
    ['foo' => 'A', 'bar' => ['baz' => 'B']],
    ['foo' => 'C', 'bar' => ['baz' => 'D']],
];
$collection = Collection::fromIterable($input);
$collection->pluck('bar'); // [['baz' => 'B'], ['baz' => 'D']]
$collection->pluck('bar.baz'); // ['B', 'D']
$collection->pluck('*.baz'); // [[null, 'B'], [null, 'D']]
