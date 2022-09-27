<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function match_check(bool $value): void
{
}

$even = static fn (int $val): bool => $val % 2 === 0;
$negative = static fn (int $val): bool => 0 > $val;
$bar = static fn (string $val): bool => 'bar' === $val;
$long = static fn (string $val): bool => mb_strlen($val) > 3;

match_check(Collection::fromIterable([1, 2, 3])->match($even));
match_check(Collection::fromIterable([1, 2, 3])->match($even, $negative));
match_check(Collection::fromIterable([-1, -2, -3])->match($even, static fn (): bool => false));

match_check(Collection::fromIterable(['foo' => 'bar', 'baz' => 'taz'])->match($bar));
match_check(Collection::fromIterable(['foo' => 'bar', 'baz' => 'taz'])->match($bar, static fn (): bool => false));
match_check(Collection::fromIterable(['foo' => 'bar', 'baz' => 'looooooooong'])->match($bar, $long));

if (Collection::fromIterable([1, 2, 3])->match($even)) {
    // do something
}
