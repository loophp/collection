<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

/**
 * @param null|mixed $_
 */
function min_takeNull($_): void
{
}
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

min_takeNull(Collection::empty()->min());

min_takeInt(Collection::empty()->min(0));

min_takeIntOrNull(Collection::fromIterable([1, 2, 3, -2, 4])->min());

min_takeIntOrNull(Collection::fromIterable([1, 2, null, -2, 4])->min());

min_takeStringOrNull(Collection::fromIterable(['f' => 'foo', 'b' => 'bar'])->min());

min_takeStringOrNull(Collection::fromIterable(['f' => 'foo', 'b' => null])->min());

// VALID failures - `min` can return NULL

/** @psalm-suppress NullArgument */
min_takeInt(Collection::empty()->min());

/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
min_takeInt(Collection::fromIterable([1, 2, 3, -2, 4])->min());

/** @psalm-suppress NullArgument */
min_takeString(Collection::empty()->min());

/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
min_takeString(Collection::fromIterable(['f' => 'foo', 'b' => 'bar'])->min());
