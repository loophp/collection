<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function compare_checkListInt(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, int|null> $collection
 */
function compare_checkNullableListInt(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<string, string> $collection
 */
function compare_checkMapString(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<string, string|null> $collection
 */
function compare_checkMapNullableString(CollectionInterface $collection): void
{
}

$compareInt = static fn (int $left, int $right): int => $right < $left ? $right : $left;
$compareNullableInt = static fn (?int $left, ?int $right): ?int => $right < $left ? $right : $left;

$compareString = static fn (string $left, string $right): string => $right < $left ? $right : $left;
$compareNullableString = static fn (?string $left, ?string $right): ?string => $right < $left ? $right : $left;

// These are valid and should work, however Psalm restricts the values that the callable
// is allowed to accept to the list of values contained in the collection
/** @psalm-suppress ArgumentTypeCoercion */
compare_checkListInt(Collection::fromIterable([1, 2, 3, -2, 4])->compare($compareInt));
/** @psalm-suppress ArgumentTypeCoercion */
compare_checkMapString(Collection::fromIterable(['f' => 'foo', 'b' => 'bar'])->compare($compareString));
/** @psalm-suppress ArgumentTypeCoercion,InvalidArgument */
compare_checkNullableListInt(Collection::fromIterable([1, 2, null, -2, 4])->compare($compareNullableInt));
/** @psalm-suppress ArgumentTypeCoercion,InvalidArgument */
compare_checkMapNullableString(Collection::fromIterable(['f' => 'foo', 'b' => null])->compare($compareNullableString));

// VALID failures
// usage of callback with different types for `carry` and `value`
/** @psalm-suppress ArgumentTypeCoercion @phpstan-ignore-next-line */
compare_checkListInt(Collection::fromIterable([1, 2, 3, -2, 4])->compare($compareNullableInt));
/** @psalm-suppress ArgumentTypeCoercion @phpstan-ignore-next-line */
compare_checkMapString(Collection::fromIterable(['f' => 'foo', 'b' => 'bar'])->compare($compareNullableString));
