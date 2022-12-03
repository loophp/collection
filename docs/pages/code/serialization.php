<?php

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;

// Example 1 -> using `json_encode`

// a) with list, ordered keys
json_encode(Collection::fromIterable([1, 2, 3]), \JSON_THROW_ON_ERROR); // JSON: '[1, 2, 3]'

// b) with list, missing keys
$col = Collection::fromIterable([1, 2, 3])
    ->filter(static fn (int $val): bool => $val % 2 !== 0); // [0 => 1, 2 => 3]

json_encode($col, \JSON_THROW_ON_ERROR); // JSON: '{"0": 1, "2": 3}'

// c) with list, missing keys, with `normalize`
$col = Collection::fromIterable([1, 2, 3])
    ->filter(static fn (int $val): bool => $val % 2 !== 0)
    ->normalize(); // [0 => 1, 1 => 3]

json_encode($col, \JSON_THROW_ON_ERROR); // JSON: '[1, 3]'

// d) with associative array
json_encode(Collection::fromIterable(['foo' => 1, 'bar' => 2]), \JSON_THROW_ON_ERROR); // JSON: '{"foo": 1, "bar": 2}'

// e) with associative array, with `normalize`

$col = Collection::fromIterable(['foo' => 1, 'bar' => 2])
    ->normalize(); // [0 => 1, 1 => 2]

json_encode($col, \JSON_THROW_ON_ERROR); // JSON: '[1, 2]'

// Example 2 -> using custom serializer (all previous behaviours apply)

/** @var Symfony\Component\Serializer\Serializer $serializer */
$serializer = new Serializer(); // parameters omitted for brevity

$serializer->serialize(Collection::fromIterable([1, 2, 3]), 'json'); // JSON: '[1, 2, 3]'
