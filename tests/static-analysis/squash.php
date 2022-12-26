<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @psalm-param CollectionInterface<int<0, 2>, 1|2|3> $collection
 *
 * @phpstan-param CollectionInterface<int, int> $collection
 */
function squash_checkList1(CollectionInterface $collection): void
{
}
/**
 * @psalm-param CollectionInterface<int, 1|2> $collection
 *
 * @phpstan-param CollectionInterface<int, int> $collection
 */
function squash_checkList2(CollectionInterface $collection): void
{
}
/**
 * @psalm-param CollectionInterface<int<0, 2>, 'a'|'b'|'c'> $collection
 *
 * @phpstan-param CollectionInterface<int, string> $collection
 */
function squash_checkStringList1(CollectionInterface $collection): void
{
}
/**
 * @psalm-param CollectionInterface<int, 'b'|'f'> $collection
 *
 * @phpstan-param CollectionInterface<int, string> $collection
 */
function squash_checkStringList2(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function squash_checkMap(CollectionInterface $collection): void
{
}

squash_checkList1(Collection::fromIterable([1, 2, 3])->squash());
squash_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->squash());
squash_checkStringList1(Collection::fromIterable(['a', 'b', 'c'])->squash());

// These work because `normalize` always changes the key to `int`
squash_checkList2(Collection::fromIterable(['foo' => 1, 'bar' => 2])->normalize()->squash());
squash_checkStringList2(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->normalize()->squash());

// VALID failures -> `squash` does not change the key and value types
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
squash_checkList1(Collection::fromIterable(['a', 'b', 'c'])->squash());
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
squash_checkStringList2(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->squash());
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
squash_checkMap(Collection::fromIterable(['foo' => 1, 'bar' => 2])->squash());
