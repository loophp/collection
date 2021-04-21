<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;

$monteCarloMethod = static function ($in = 0, $total = 1) {
    $randomNumber1 = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
    $randomNumber2 = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();

    if (1 >= (($randomNumber1 ** 2) + ($randomNumber2 ** 2))) {
        ++$in;
    }

    return ['in' => $in, 'total' => ++$total];
};

$pi_approximation = Collection::unfold($monteCarloMethod)
    ->map(
        static function ($value) {
            return 4 * $value['in'] / $value['total'];
        }
    )
    ->window(1)
    ->drop(1)
    ->until(
        static function (array $value): bool {
            return 0.00001 > abs($value[0] - $value[1]);
        }
    )
    ->last();

print_r($pi_approximation->all());
