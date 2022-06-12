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
function max_checkListInt(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, int|null> $collection
 */
function max_checkNullableListInt(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<string, string> $collection
 */
function max_checkMapString(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<string, string|null> $collection
 */
function max_checkMapNullableString(CollectionInterface $collection): void
{
}

$compareInt = static fn (int $left, int $right): int => $right > $left ? $right : $left;
$compareNullableInt = static fn (?int $left, ?int $right): ?int => $right > $left ? $right : $left;

$compareString = static fn (string $left, string $right): string => $right > $left ? $right : $left;
$compareNullableString = static fn (?string $left, ?string $right): ?string => $right > $left ? $right : $left;

max_checkListInt(Collection::empty()->max());
max_checkListInt(Collection::fromIterable([1, 2, 3, -2, 4])->max());

max_checkNullableListInt(Collection::empty()->max());
max_checkNullableListInt(Collection::fromIterable([1, 2, null, -2, 4])->max());

max_checkMapString(Collection::empty()->max());
max_checkMapString(Collection::fromIterable(['f' => 'foo', 'b' => 'bar'])->max());

max_checkMapNullableString(Collection::empty()->max());
max_checkMapNullableString(Collection::fromIterable(['f' => 'foo', 'b' => null])->max());

// These are valid and should work, however Psalm restricts the values that the callable
// is allowed to accept to the list of values contained in the collection
/** @psalm-suppress ArgumentTypeCoercion */
max_checkListInt(Collection::fromIterable([1, 2, 3, -2, 4])->max($compareInt));
/** @psalm-suppress ArgumentTypeCoercion */
max_checkMapString(Collection::fromIterable(['f' => 'foo', 'b' => 'bar'])->max($compareString));
/** @psalm-suppress ArgumentTypeCoercion,InvalidArgument */
max_checkNullableListInt(Collection::fromIterable([1, 2, null, -2, 4])->max($compareNullableInt));
/** @psalm-suppress ArgumentTypeCoercion,InvalidArgument */
max_checkMapNullableString(Collection::fromIterable(['f' => 'foo', 'b' => null])->max($compareNullableString));

// VALID failures
// usage of callback with different types for `carry` and `value`
/** @psalm-suppress ArgumentTypeCoercion @phpstan-ignore-next-line */
max_checkListInt(Collection::fromIterable([1, 2, 3, -2, 4])->max($compareNullableInt));
/** @psalm-suppress ArgumentTypeCoercion @phpstan-ignore-next-line */
max_checkMapString(Collection::fromIterable(['f' => 'foo', 'b' => 'bar'])->max($compareNullableString));
