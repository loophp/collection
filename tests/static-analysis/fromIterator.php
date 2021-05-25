<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

/**
 * @param Collection<int, int> $collection
 */
function checkNumeric(Collection $collection): void
{
}
/**
 * @param Collection<string, int> $collection
 */
function checkMap(Collection $collection): void
{
}
/** @var Closure(): Generator<int, int> $generatorNumeric */
$generatorNumeric = static fn (): Generator => yield from range(1, 3);
/** @var Closure(): Generator<string, int> $generatorMap */
$generatorMap = static fn (): Generator => yield 'myKey' => 1;

/** @var array<int, int> $arrayNumeric */
$arrayNumeric = range(1, 3);
/** @var array<string, int> $arrayMap */
$arrayMap = ['foo' => 1, 'bar' => 2];

/** @var ArrayIterator<int, int> $arrayIteratorNumeric */
$arrayIteratorNumeric = new ArrayIterator(range(1, 3));
/** @var ArrayIterator<string, int> $arrayIteratorMap */
$arrayIteratorMap = new ArrayIterator(['foo' => 1, 'bar' => 2]);

checkNumeric(Collection::fromIterable($generatorNumeric()));
checkMap(Collection::fromIterable($generatorMap()));

checkNumeric(Collection::fromIterable($arrayNumeric));
checkMap(Collection::fromIterable($arrayMap));

checkNumeric(Collection::fromIterable($arrayIteratorNumeric));
checkMap(Collection::fromIterable($arrayIteratorMap));
