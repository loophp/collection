<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function drop_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function drop_checkMap(CollectionInterface $collection): void
{
}

drop_checkList(Collection::fromIterable([1, 2, 3])->drop(1));
drop_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->drop(2));

// VALID failures -> `drop` does not change the key and value types
/** @psalm-suppress InvalidScalarArgument */
drop_checkList(Collection::fromIterable(['a', 'b', 'c'])->drop(1));
/** @psalm-suppress InvalidScalarArgument */
drop_checkMap(Collection::fromIterable(['foo' => 1, 'bar' => 2])->drop(3));
