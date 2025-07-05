<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

/**
 * @phpstan-param Collection<int, int> $collection
 *
 * @psalm-param Collection<int<0, max>, int>|Collection<int, int<min, max>> $collection
 */
function fromCallable_checkList(Collection $collection): void {}
/**
 * @param Collection<string, int> $collection
 */
function fromCallable_checkMap(Collection $collection): void {}
/**
 * @phpstan-param Collection<int, int|string> $collection
 *
 * @psalm-param Collection<1|3|4, '5'|'b'|'c'|2> $collection
 */
function fromCallable_checkMixed1(Collection $collection): void {}
/**
 * @phpstan-param Collection<int, int|string> $collection
 *
 * @psalm-param Collection<int, int|string>|Collection<int<0, 4>, '3'|'b'|1|2|5> $collection
 */
function fromCallable_checkMixed2(Collection $collection): void {}

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
        yield 1;

        yield 2;

        yield '3';

        yield 'b';

        yield 5;
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
        yield 1;

        yield 2;

        yield '3';

        yield 'b';

        yield 5;
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
        yield 1;

        yield 2;

        yield '3';

        yield 'b';

        yield 5;
    }
};

fromCallable_checkList(Collection::fromCallable($generatorClosureList));
fromCallable_checkMap(Collection::fromCallable($generatorClosureMap));
fromCallable_checkMixed1(Collection::fromCallable($generatorClosureMixed));

fromCallable_checkList(Collection::fromCallable($arrayList));
fromCallable_checkMap(Collection::fromCallable($arrayMap));
fromCallable_checkMixed2(Collection::fromCallable($arrayMixed));

fromCallable_checkList(Collection::fromCallable([$classWithMethod, 'getValues']));
fromCallable_checkMap(Collection::fromCallable([$classWithMethod, 'getKeyValues']));
fromCallable_checkMixed2(Collection::fromCallable([$classWithMethod, 'getMixed']));

fromCallable_checkList(Collection::fromCallable([$classWithStaticMethod, 'getValues']));
fromCallable_checkMap(Collection::fromCallable([$classWithStaticMethod, 'getKeyValues']));
fromCallable_checkMixed2(Collection::fromCallable([$classWithStaticMethod, 'getMixed']));

fromCallable_checkList(Collection::fromCallable($invokableClassList));
fromCallable_checkMap(Collection::fromCallable($invokableClassMap));
fromCallable_checkMixed2(Collection::fromCallable($invokableClassMixed));
