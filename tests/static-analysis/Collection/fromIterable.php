<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__.'/../../../vendor/autoload.php';

use loophp\collection\Collection;

/**
 * @param Collection<int, int> $collection
 */
function fromIterable_checkNumeric(Collection $collection): void
{
}
/**
 * @param Collection<string, int> $collection
 */
function fromIterable_checkMap(Collection $collection): void
{
}
/**
 * @param Collection<int, int|string> $collection
 */
function fromIterable_checkMixed(Collection $collection): void
{
}

/** @var Closure(): Generator<int, int> $generatorNumeric */
$generatorNumeric = static fn (): Generator => yield from range(1, 3);
/** @var Closure(): Generator<string, int> $generatorMap */
$generatorMap = static fn (): Generator => yield 'myKey' => 1;
/** @var Closure(): Generator<int, int|string> $generatorMixed */
$generatorMixed = static function (): Generator {
    yield 1 => 2;

    yield 3 => 'b';

    yield 1 => 'c';

    yield 4 => '5';
};

/** @var array<int, int> $arrayNumeric */
$arrayNumeric = range(1, 3);
/** @var array<string, int> $arrayMap */
$arrayMap = ['foo' => 1, 'bar' => 2];
$arrayMixed = [1, 2, '3', 'b', 5];

/** @var ArrayIterator<int, int> $arrayIteratorNumeric */
$arrayIteratorNumeric = new ArrayIterator(range(1, 3));
/** @var ArrayIterator<string, int> $arrayIteratorMap */
$arrayIteratorMap = new ArrayIterator(['foo' => 1, 'bar' => 2]);
/** @var ArrayIterator<int, int|string> $arrayIteratorMixed */
$arrayIteratorMixed = new ArrayIterator([1, 2, '3', 'b', 5]);

fromIterable_checkNumeric(Collection::fromIterable($generatorNumeric()));
fromIterable_checkMap(Collection::fromIterable($generatorMap()));
fromIterable_checkMixed(Collection::fromIterable($generatorMixed()));

fromIterable_checkNumeric(Collection::fromIterable($arrayNumeric));
fromIterable_checkMap(Collection::fromIterable($arrayMap));
fromIterable_checkMixed(Collection::fromIterable($arrayMixed));

fromIterable_checkNumeric(Collection::fromIterable($arrayIteratorNumeric));
fromIterable_checkMap(Collection::fromIterable($arrayIteratorMap));
fromIterable_checkMixed(Collection::fromIterable($arrayIteratorMixed));
