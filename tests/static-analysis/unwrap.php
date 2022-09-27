<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function unwrap_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function unwrap_checkMap(CollectionInterface $collection): void
{
}

unwrap_checkList(Collection::fromIterable([1, 2, 3])->unwrap());
unwrap_checkList(Collection::fromIterable([[1], 2, 3])->unwrap());

unwrap_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->unwrap());
unwrap_checkMap(Collection::fromIterable(['foo' => 'f', ['bar' => 'b']])->unwrap());

// Below are examples of usages that are technically incorrect but are allowed
// by static analysis because `unwrap` needs to be flexible and cannot be properly typed

unwrap_checkList(Collection::fromIterable([['foo'], 2, 3])->unwrap());
unwrap_checkList(Collection::fromIterable([[1, [4]], 2, 3])->unwrap());
unwrap_checkMap(Collection::fromIterable(['foo' => 'f', ['bar' => ['b', 'car' => 'c']]])->unwrap());
