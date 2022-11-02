<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function normalize_checkIntList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, string> $collection
 */
function normalize_checkStringList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function normalize_checkStringMap(CollectionInterface $collection): void
{
}

normalize_checkIntList(Collection::fromIterable([1, 2, 3])->normalize());
normalize_checkStringList(Collection::fromIterable(['foo' => 'f', 'bar' => 'f'])->normalize());

// VALID failure -> `normalize` always returns a collection with `int` keys
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
normalize_checkStringMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'f'])->normalize());
