<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

$result = Collection::fromIterable(range('A', 'E'))
    ->combine(...range('e', 'a')); // ['e' => 'A', 'd' => 'B', 'c' => 'C', 'b' => 'D', 'a' => 'E']

$result = Collection::fromIterable(range('a', 'e'))
    ->combine(...range('a', 'c')); // ['a' => 'a', 'b' => 'b', 'c' => 'c', 'd' => null, 'e' => null]

$result = Collection::fromIterable(range('a', 'c'))
    ->combine(...range('a', 'e')); // ['a' => 'a', 'b' => 'b', 'c' => 'c', null => 'd', null => 'e']
