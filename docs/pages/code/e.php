<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;

$multiplication = static fn (float $value1, float $value2): float => $value1 * $value2;

$addition = static fn (float $value1, float $value2): float => $value1 + $value2;

$fact = static fn (float $number): float => (float) Collection::range(1, $number + 1)->foldLeft($multiplication, 1)->current();

$number_e_approximation = Collection::unfold(static fn(int $i = 0): int => $i + 1)
    ->map(static fn (float $value): float => $value / $fact($value))
    ->until(static fn (float $value): bool => 10 ** -12 > $value)
    ->foldLeft($addition, 0)
    ->current();

var_dump($number_e_approximation); // 2.718281828459
