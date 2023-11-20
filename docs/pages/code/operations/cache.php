<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

$fopen = fopen(__DIR__ . '/vendor/autoload.php', 'rb');

$collection = Collection::fromResource($fopen)
    ->cache();

for ($i = 0; 3 > $i; ++$i) {
    foreach ($collection as $value) {
        print_r($value);
    }
}

$callable = static function () {
    var_dump('Generator call');

    yield 'a' => 'a';
};

$collection = Collection::fromCallable($callable)
    ->cache();

for ($i = 0; 3 > $i; ++$i) {
    foreach ($collection as $value) {
        print_r($value);
    }
}
