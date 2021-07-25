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
 * @param CollectionInterface<int, int|null> $collection
 */
function reduce_checkListNullableInt(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, int> $collection
 */
function reduce_checkListInt(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string|null> $collection
 */
function reduce_checkMapNullableString(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function reduce_checkMapString(CollectionInterface $collection): void
{
}

$sumNullable = static fn (?int $carry, int $value): int => null === $carry ? $value : $carry + $value;
$sum = static fn (int $carry, int $value): int => $carry + $value;

$concatNullable = static fn (?string $carry, string $string): string => null === $carry ? $string : $carry . $string;
$concat = static fn (string $carry, string $string): string => sprintf('%s%s', $carry, $string);

reduce_checkListNullableInt(Collection::fromIterable([1, 2, 3])->reduce($sumNullable));
reduce_checkListInt(Collection::fromIterable([1, 2, 3])->reduce($sum, 0));

reduce_checkMapNullableString(Collection::fromIterable(['z' => 'a', 'y' => 'b', 'x' => 'c'])->reduce($concatNullable));
reduce_checkMapString(Collection::fromIterable(['z' => 'a', 'y' => 'b', 'x' => 'c'])->reduce($concat, ''));

// VALID failures

// usage of incorrectly-defined callbacks when initial value is NULL
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
reduce_checkListNullableInt(Collection::fromIterable([1, 2, 3])->reduce($sum));
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
reduce_checkMapNullableString(Collection::fromIterable(['z' => 'a', 'y' => 'b', 'x' => 'c'])->reduce($concat));

// not accounting for possible NULL type in final collection when initial value is NULL
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
reduce_checkListInt(Collection::fromIterable([1, 2, 3])->reduce($sumNullable));
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
reduce_checkMapString(Collection::fromIterable(['z' => 'a', 'y' => 'b', 'x' => 'c'])->reduce($concatNullable));
