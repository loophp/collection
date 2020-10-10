<?php

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Operation\Sortable;

$min = 0;
$max = 10000;
$groups = 1000;

$randomGenerator = static function () use ($min, $max): int {
    return random_int($min, $max);
};

$distribution = Collection::unfold($randomGenerator)
    ->limit($max)
    ->map(
        static function (int $value) use ($max, $groups): string {
            for ($i = 0; ($max / $groups) > $i; ++$i) {
                if ($i * $groups <= $value && ($i + 1) * $groups >= $value) {
                    return sprintf('%s <= x <= %s', $i * $groups, ($i + 1) * $groups);
                }
            }
        }
    )
    ->groupBy(
        static function ($value, $key) {
            return $value;
        }
    )
    ->map(
        static function (array $value): int {
            return \count($value);
        }
    )
    ->sort(
        Sortable::BY_KEYS,
        static function (string $left, string $right): int {
            [$left_min_limit] = explode(' ', $left);
            [$right_min_limit] = explode(' ', $right);

            return $left_min_limit <=> $right_min_limit;
        }
    );

print_r($distribution->all());

/*
Array
(
    [0 <= x <= 100] => 101086
    [100 <= x <= 200] => 100144
    [200 <= x <= 300] => 99408
    [300 <= x <= 400] => 100079
    [400 <= x <= 500] => 99514
    [500 <= x <= 600] => 100227
    [600 <= x <= 700] => 99983
    [700 <= x <= 800] => 99942
    [800 <= x <= 900] => 99429
    [900 <= x <= 1000] => 100188
)
 */
