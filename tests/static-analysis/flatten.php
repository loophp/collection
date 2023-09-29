<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function flatten_checkList(CollectionInterface $collection): void {}
/**
 * @param CollectionInterface<string, string> $collection
 */
function flatten_checkMap(CollectionInterface $collection): void {}

flatten_checkList(Collection::fromIterable([1, 2, 3])->flatten());
flatten_checkList(Collection::fromIterable([[1], 2, 3])->flatten());
flatten_checkList(Collection::fromIterable([[1], 2, 3])->flatten(1));
flatten_checkList(Collection::fromIterable([[1], 2, 3])->flatten(2));

flatten_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->flatten());
flatten_checkMap(Collection::fromIterable(['foo' => 'f', ['bar' => 'b']])->flatten());
flatten_checkMap(Collection::fromIterable(['foo' => 'f', ['bar' => 'b']])->flatten(1));
flatten_checkMap(Collection::fromIterable(['foo' => 'f', ['bar' => 'b']])->flatten(2));

// Below are examples of usages that are technically incorrect but are allowed
// by static analysis because `flatten` needs to be flexible and cannot be properly typed

flatten_checkList(Collection::fromIterable([['foo'], 2, 3])->flatten());
flatten_checkList(Collection::fromIterable([[1, [4]], 2, 3])->flatten(1));
flatten_checkMap(Collection::fromIterable(['foo' => 'f', ['bar' => ['b', 'car' => 'c']]])->flatten(1));
