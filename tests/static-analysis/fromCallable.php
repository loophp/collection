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
/** @var Closure(): Generator<int, int> $generatorClosureNumeric */
$generatorClosureNumeric = static fn (): Generator => yield from range(1, 3);
/** @var Closure(): Generator<string, int> $generatorClosureMap */
$generatorClosureMap = static fn (): Generator => yield 'myKey' => 1;

/** @var Closure(): array<int, int> $arrayNumeric */
$arrayNumeric = static fn (): array => range(1, 3);
/** @var Closure(): array<string, int> $arrayMap */
$arrayMap = static fn (): array => ['myKey' => 1];

/** @var Closure(): ArrayIterator<int, int> $arrayIteratorNumeric */
$arrayIteratorNumeric = static fn (int $a, int $b): ArrayIterator => new ArrayIterator(range($a, $b));
/** @var Closure(): ArrayIterator<string, int> $arrayIteratorMap */
$arrayIteratorMap = static fn (int $x): ArrayIterator => new ArrayIterator(['myKey' => $x]);

$classWithMethod = new class() {
    /**
     * @return Generator<string, int>
     */
    public function getKeyValues(): Generator
    {
        yield 'myKey' => 1;
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
     * @return Generator<int, int>
     */
    public static function getValues(): Generator
    {
        return yield from range(1, 5);
    }
};
$invokableClassNumeric = new class() {
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

checkNumeric(Collection::fromCallable($generatorClosureNumeric));
checkMap(Collection::fromCallable($generatorClosureMap));

checkNumeric(Collection::fromCallable($arrayNumeric));
checkMap(Collection::fromCallable($arrayMap));

checkNumeric(Collection::fromCallable($arrayIteratorNumeric, 1, 3));
checkMap(Collection::fromCallable($arrayIteratorMap, 1));

checkNumeric(Collection::fromCallable([$classWithMethod, 'getValues']));
checkMap(Collection::fromCallable([$classWithMethod, 'getKeyValues']));

checkNumeric(Collection::fromCallable([$classWithStaticMethod, 'getValues']));
checkMap(Collection::fromCallable([$classWithStaticMethod, 'getKeyValues']));

checkNumeric(Collection::fromCallable($invokableClassNumeric));
checkMap(Collection::fromCallable($invokableClassMap));
