<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function max_takeInt(int $int): void
{
}
function max_takeIntOrNull(?int $int): void
{
}
function max_takeString(string $string): void
{
}
function max_takeStringOrNull(?string $string): void
{
}

max_takeIntOrNull(Collection::empty()->max());
max_takeIntOrNull(Collection::fromIterable([1, 2, 3, -2, 4])->max());

max_takeIntOrNull(Collection::empty()->max());
max_takeIntOrNull(Collection::fromIterable([1, 2, null, -2, 4])->max());

max_takeStringOrNull(Collection::empty()->max());
max_takeStringOrNull(Collection::fromIterable(['f' => 'foo', 'b' => 'bar'])->max());

max_takeStringOrNull(Collection::empty()->max());
max_takeStringOrNull(Collection::fromIterable(['f' => 'foo', 'b' => null])->max());

// VALID failures - `max` can return NULL

/** @psalm-suppress PossiblyNullArgument */
max_takeInt(Collection::empty()->max());

/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
max_takeInt(Collection::fromIterable([1, 2, 3, -2, 4])->max());

/** @psalm-suppress PossiblyNullArgument */
max_takeString(Collection::empty()->max());

/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
max_takeString(Collection::fromIterable(['f' => 'foo', 'b' => 'bar'])->max());
