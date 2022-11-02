<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function compare_takeInt(int $int): void
{
}
function compare_takeIntOrNull(?int $int): void
{
}
function compare_takeString(string $string): void
{
}
function compare_takeStringOrNull(?string $string): void
{
}

$compareInt = static fn (int $left, int $right): int => $right < $left ? $right : $left;
$compareNullableInt = static fn (?int $left, ?int $right): ?int => $right < $left ? $right : $left;

$compareString = static fn (string $left, string $right): string => $right < $left ? $right : $left;
$compareNullableString = static fn (?string $left, ?string $right): ?string => $right < $left ? $right : $left;

// These are valid and should work, however Psalm restricts the values that the callable
// is allowed to accept to the list of values contained in the collection
/** @psalm-suppress ArgumentTypeCoercion */
compare_takeIntOrNull(Collection::fromIterable([1, 2, 3, -2, 4])->compare($compareInt));
/** @psalm-suppress ArgumentTypeCoercion */
compare_takeStringOrNull(Collection::fromIterable(['f' => 'foo', 'b' => 'bar'])->compare($compareString));
/** @psalm-suppress ArgumentTypeCoercion,InvalidArgument */
compare_takeIntOrNull(Collection::fromIterable([1, 2, null, -2, 4])->compare($compareNullableInt));
/** @psalm-suppress ArgumentTypeCoercion,InvalidArgument */
compare_takeStringOrNull(Collection::fromIterable(['f' => 'foo', 'b' => null])->compare($compareNullableString));

// VALID failures

// `compare` can return NULL
/** @psalm-suppress ArgumentTypeCoercion,PossiblyNullArgument */
compare_takeInt(Collection::fromIterable([1, 2, 3, -2, 4])->compare($compareInt));
/** @psalm-suppress ArgumentTypeCoercion,PossiblyNullArgument */
compare_takeString(Collection::fromIterable(['f' => 'foo', 'b' => 'bar'])->compare($compareString));

// usage of callback with different types for `carry` and `value`
/** @psalm-suppress ArgumentTypeCoercion */
compare_takeIntOrNull(Collection::fromIterable([1, 2, 3, -2, 4])->compare($compareNullableInt));
/** @psalm-suppress ArgumentTypeCoercion */
compare_takeStringOrNull(Collection::fromIterable(['f' => 'foo', 'b' => 'bar'])->compare($compareNullableString));
