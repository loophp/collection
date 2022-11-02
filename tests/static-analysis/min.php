<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function min_takeInt(int $int): void
{
}
function min_takeIntOrNull(?int $int): void
{
}
function min_takeString(string $string): void
{
}
function min_takeStringOrNull(?string $string): void
{
}

min_takeIntOrNull(Collection::empty()->min());
min_takeIntOrNull(Collection::fromIterable([1, 2, 3, -2, 4])->min());

min_takeIntOrNull(Collection::empty()->min());
min_takeIntOrNull(Collection::fromIterable([1, 2, null, -2, 4])->min());

min_takeStringOrNull(Collection::empty()->min());
min_takeStringOrNull(Collection::fromIterable(['f' => 'foo', 'b' => 'bar'])->min());

min_takeStringOrNull(Collection::empty()->min());
min_takeStringOrNull(Collection::fromIterable(['f' => 'foo', 'b' => null])->min());

// VALID failures - `min` can return NULL

/** @psalm-suppress NullArgument */
min_takeInt(Collection::empty()->min());

/** @psalm-suppress PossiblyNullArgument */
min_takeInt(Collection::fromIterable([1, 2, 3, -2, 4])->min());

/** @psalm-suppress NullArgument */
min_takeString(Collection::empty()->min());

/** @psalm-suppress PossiblyNullArgument */
min_takeString(Collection::fromIterable(['f' => 'foo', 'b' => 'bar'])->min());
