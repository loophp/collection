<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function fromIterable_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, int> $collection
 */
function fromIterable_checkMap(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, int|string> $collection
 */
function fromIterable_checkMixed(CollectionInterface $collection): void
{
}

$generatorList = static fn (): Generator => yield from range(1, 3);
$generatorMap = static fn (): Generator => yield 'myKey' => 1;
$generatorMixed = static function (): Generator {
    yield 1 => 2;

    yield 3 => 'b';

    yield 1 => 'c';

    yield 4 => '5';
};

$arrayList = range(1, 3);
$arrayMap = ['foo' => 1, 'bar' => 2];
$arrayMixed = [1, 2, '3', 'b', 5];

$arrayIteratorList = new ArrayIterator(range(1, 3));
$arrayIteratorMap = new ArrayIterator(['foo' => 1, 'bar' => 2]);
$arrayIteratorMixed = new ArrayIterator([1, 2, '3', 'b', 5]);

fromIterable_checkList(Collection::fromIterable($generatorList()));
fromIterable_checkMap(Collection::fromIterable($generatorMap()));
fromIterable_checkMixed(Collection::fromIterable($generatorMixed()));

fromIterable_checkList(Collection::fromIterable($arrayList));
fromIterable_checkMap(Collection::fromIterable($arrayMap));
fromIterable_checkMixed(Collection::fromIterable($arrayMixed));

fromIterable_checkList(Collection::fromIterable($arrayIteratorList));
fromIterable_checkMap(Collection::fromIterable($arrayIteratorMap));
fromIterable_checkMixed(Collection::fromIterable($arrayIteratorMixed));
