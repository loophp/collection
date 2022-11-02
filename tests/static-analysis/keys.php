<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function keys_checkIntList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, string> $collection
 */
function keys_checkStringList(CollectionInterface $collection): void
{
}

keys_checkIntList(Collection::fromIterable([1, 2, 3])->keys());
keys_checkStringList(Collection::fromIterable(['foo' => 'f', 'bar' => 'f'])->keys());

// VALID failure -> mixed keys
/** @psalm-suppress InvalidScalarArgument */
keys_checkIntList(Collection::fromIterable([1, 2, 'foo' => 4])->keys());
/** @psalm-suppress InvalidScalarArgument */
keys_checkStringList(Collection::fromIterable([1, 2, 'foo' => 4])->keys());
