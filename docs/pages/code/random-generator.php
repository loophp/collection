<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;

// Generate 300 distinct random numbers between 0 and 1000
$random = static function () {
    return mt_rand() / mt_getrandmax();
};

$random_numbers = Collection::unfold($random)
    ->map(static fn ($value): float => floor($value * 1000) + 1)
    ->distinct()
    ->limit(300)
    ->all();

print_r($random_numbers);
