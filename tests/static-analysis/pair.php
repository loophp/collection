<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int|null> $collection
 */
function pair_checkListNullableInt(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, int> $collection
 */
function pair_checkListInt(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string|null> $collection
 */
function pair_checkMapNullableString(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function pair_checkMapString(CollectionInterface $collection): void
{
}

pair_checkListNullableInt(Collection::fromIterable([1, 2, 3])->pair());
pair_checkMapNullableString(Collection::fromIterable(range('a', 'b'))->pair());

// VALID failures -> `pair` can return `NULL` in the collection
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
pair_checkListInt(Collection::fromIterable([1, 2, 3])->pair());
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
pair_checkMapString(Collection::fromIterable(range('a', 'b'))->pair());

// VALID failures -> `pair` will use values as keys
/** @psalm-suppress InvalidScalarArgument @phpstan-ignore-next-line */
pair_checkListNullableInt(Collection::fromIterable(['1', '2', '3'])->pair());
/** @psalm-suppress InvalidScalarArgument @phpstan-ignore-next-line */
pair_checkMapNullableString(Collection::fromIterable(['foo' => 1, 'bar' => 2])->pair());
