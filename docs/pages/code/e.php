<?php

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;

$multiplication = static fn (float $value1, float $value2): float => $value1 * $value2;

$addition = static fn (float $value1, float $value2): float => $value1 + $value2;

$fact = static fn (float $number): float => (float) Collection::range(1, $number + 1)
    ->foldLeft($multiplication, 1);

$number_e_approximation = Collection::unfold(static fn (int $i = 0): array => [$i + 1])
    ->unwrap()
    ->map(static fn (float $value): float => $value / $fact($value))
    ->until(static fn (float $value): bool => 10 ** -12 > $value)
    ->foldLeft($addition, 0);

var_dump($number_e_approximation); // 2.718281828459
