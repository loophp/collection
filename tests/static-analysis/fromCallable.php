<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function fromCallable_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, int> $collection
 */
function fromCallable_checkMap(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, int|string> $collection
 */
function fromCallable_checkMixed(CollectionInterface $collection): void
{
}

$generatorClosureList = static fn (): Generator => yield from range(1, 3);
$generatorClosureMap = static fn (): Generator => yield 'myKey' => 1;
$generatorClosureMixed = static function (): Generator {
    yield 1 => 2;

    yield 3 => 'b';

    yield 1 => 'c';

    yield 4 => '5';
};

$arrayList = static fn (): array => range(1, 3);
$arrayMap = static fn (): array => ['myKey' => 1];
$arrayMixed = static fn (): array => [1, 2, '3', 'b', 5];

/** @var Closure(): ArrayIterator<int, int> $arrayIteratorList */
$arrayIteratorList = static fn (int $a, int $b): ArrayIterator => new ArrayIterator(range($a, $b));
$arrayIteratorMap = static fn (int $x): ArrayIterator => new ArrayIterator(['myKey' => $x]);
$arrayIteratorMixed = static fn (): ArrayIterator => new ArrayIterator([1, 2, '3', 5, 'b']);

$classWithMethod = new class() {
    /**
     * @return Generator<string, int>
     */
    public function getKeyValues(): Generator
    {
        yield 'myKey' => 1;
    }

    /**
     * @return Generator<int, int|string>
     */
    public function getMixed(): Generator
    {
        yield from [1, 2, '3', 'b', 5];
    }

    /**
     * @return Generator<int, int>
     */
    public function getValues(): Generator
    {
        yield from range(1, 5);
    }
};
$classWithStaticMethod = new class() {
    /**
     * @return Generator<string, int>
     */
    public static function getKeyValues(): Generator
    {
        yield 'myKey' => 1;
    }

    /**
     * @return Generator<int, int|string>
     */
    public static function getMixed(): Generator
    {
        yield from [1, 2, '3', 'b', 5];
    }

    /**
     * @return Generator<int, int>
     */
    public static function getValues(): Generator
    {
        return yield from range(1, 5);
    }
};
$invokableClassList = new class() {
    /**
     * @return Generator<int, int>
     */
    public function __invoke(): Generator
    {
        yield from range(1, 5);
    }
};
$invokableClassMap = new class() {
    /**
     * @return Generator<string, int>
     */
    public function __invoke(): Generator
    {
        yield 'myKey' => 1;
    }
};
$invokableClassMixed = new class() {
    /**
     * @return Generator<int, int|string>
     */
    public function __invoke(): Generator
    {
        yield from [1, 2, '3', 'b', 5];
    }
};

fromCallable_checkList(Collection::fromCallable($generatorClosureList));
fromCallable_checkMap(Collection::fromCallable($generatorClosureMap));
fromCallable_checkMixed(Collection::fromCallable($generatorClosureMixed));

fromCallable_checkList(Collection::fromCallable($arrayList));
fromCallable_checkMap(Collection::fromCallable($arrayMap));
fromCallable_checkMixed(Collection::fromCallable($arrayMixed));

fromCallable_checkList(Collection::fromCallable($arrayIteratorList, 1, 3));
fromCallable_checkMap(Collection::fromCallable($arrayIteratorMap, 1));
fromCallable_checkMixed(Collection::fromCallable($arrayIteratorMixed));

fromCallable_checkList(Collection::fromCallable([$classWithMethod, 'getValues']));
fromCallable_checkMap(Collection::fromCallable([$classWithMethod, 'getKeyValues']));
fromCallable_checkMixed(Collection::fromCallable([$classWithMethod, 'getMixed']));

fromCallable_checkList(Collection::fromCallable([$classWithStaticMethod, 'getValues']));
fromCallable_checkMap(Collection::fromCallable([$classWithStaticMethod, 'getKeyValues']));
fromCallable_checkMixed(Collection::fromCallable([$classWithStaticMethod, 'getMixed']));

fromCallable_checkList(Collection::fromCallable($invokableClassList));
fromCallable_checkMap(Collection::fromCallable($invokableClassMap));
fromCallable_checkMixed(Collection::fromCallable($invokableClassMixed));
