<?php

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;

$monteCarloMethod = static function ($in = 0, $total = 1): array {
    $randomNumber1 = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
    $randomNumber2 = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();

    if (1 >= (($randomNumber1 ** 2) + ($randomNumber2 ** 2))) {
        ++$in;
    }

    return ['in' => $in, 'total' => ++$total];
};

$pi_approximation = Collection::unfold($monteCarloMethod)
    ->map(static fn ($value) => 4 * $value['in'] / $value['total'])
    ->window(1)
    ->drop(1)
    ->until(static fn (array $value): bool => 0.00001 > abs($value[0] - $value[1]))
    ->unwrap()
    ->last();

print_r($pi_approximation->all()); // [3.14...]
