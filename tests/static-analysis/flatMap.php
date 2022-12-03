<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function flatMap_checkListInt(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, stdClass> $collection
 */
function flatMap_checkListClass(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, string> $collection
 */
function flatMap_checkListString(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function flatMap_checkMapString(CollectionInterface $collection): void
{
}

$square = static fn (int $val): array => [$val ** 2];
$squareCollection = static fn (int $val): CollectionInterface => Collection::fromIterable([$val ** 2]);
$toString = static fn (int $val): array => [(string) $val];
$appendBar = static fn (string $val): array => [$val . 'bar'];
$toClass = static function (string $val): iterable {
    $class = new stdClass();
    $class->val = $val;

    return new ArrayIterator([$class]);
};
flatMap_checkListInt(Collection::fromIterable([1, 2, 3])->flatMap($square));
flatMap_checkListInt(Collection::fromIterable([1, 2, 3])->flatMap($squareCollection));
flatMap_checkListInt(Collection::fromIterable([1, 2, 3])->flatMap($square)->flatMap($square));

flatMap_checkListClass(Collection::fromIterable(['foo' => 'bar', 'bar' => 'baz'])->flatMap($toClass));
flatMap_checkMapString(Collection::fromIterable(['foo', 'bar'])->flatMap(static fn (string $val): array => [$val => $val]));

// This should work but static analysers restrict the return type
// E.g: `numeric&string` or `non-empty-string`
/** @psalm-suppress InvalidArgument */
flatMap_checkListString(Collection::fromIterable([1, 2, 3])->flatMap($toString));
/** @psalm-suppress InvalidArgument */
flatMap_checkListString(Collection::fromIterable(['foo', 'bar'])->flatMap($appendBar));
/** @psalm-suppress InvalidArgument */
flatMap_checkListString(Collection::fromIterable([1, 2, 3])->flatMap($square)->flatMap($toString)->flatMap($appendBar));

// VALID failures due to usage with wrong types

/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
flatMap_checkListInt(Collection::fromIterable(['foo' => 'bar'])->flatMap($square));
/** @psalm-suppress InvalidScalarArgument,InvalidArgument @phpstan-ignore-next-line */
flatMap_checkMapString(Collection::fromIterable([1, 2, 3])->flatMap($appendBar));
/** @psalm-suppress InvalidArgument,InvalidScalarArgument @phpstan-ignore-next-line */
flatMap_checkMapString(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->flatMap($appendBar));

// VALID failures due to usage with callbacks that do not return iterables

/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
flatMap_checkListInt(Collection::fromIterable([1, 2, 3])->flatMap(static fn (int $val): int => $val ** 2));
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
flatMap_checkListString(Collection::fromIterable(['a', 'b', 'c'])->flatMap(static fn (string $val): string => $val . 'bar'));
