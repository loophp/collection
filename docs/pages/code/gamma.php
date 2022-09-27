<?php

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;

$addition = static function (float $value1, float $value2): float {
    return $value1 + $value2;
};

$listInt = static function (int $init, callable $succ): Generator {
    yield $init;

    while (true) {
        yield $init = $succ($init);
    }
};

$N = $listInt(1, static function (int $n): int {
    return $n + 1;
});

$Y = static function (float $n): Closure {
    return static function (int $x) use ($n): float {
        return ($x ** ($n - 1)) * (\M_E ** (-$x));
    };
};

$e = static function (float $value): bool {
    return 10 ** -12 > $value;
};

// Find the factorial of this number. This is not bounded to integers!
// $number = 3; // 2 * 2 => 4
// $number = 6; // 5 * 4 * 3 * 2 => 120
$number = 5.75; // 78.78

$gamma_factorial_approximation = Collection::fromIterable($N)
    ->map($Y($number))
    ->until($e)
    ->foldLeft($addition, 0);

print_r($gamma_factorial_approximation);
