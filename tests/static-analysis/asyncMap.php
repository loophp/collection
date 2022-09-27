<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function asyncMap_checkListInt(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, string> $collection
 */
function asyncMap_checkListString(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function asyncMap_checkMapString(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, stdClass> $collection
 */
function asyncMap_checkMapClass(CollectionInterface $collection): void
{
}

$square = static fn (int $val): int => $val ** 2;
$toString = static fn (int $val): string => (string) $val;
$appendBar = static fn (string $val): string => $val . 'bar';
$toClass = static function (string $val): stdClass {
    $class = new stdClass();
    $class->val = $val;

    return $class;
};

asyncMap_checkListInt(Collection::fromIterable([1, 2, 3])->asyncMap($square));
asyncMap_checkListInt(Collection::fromIterable([1, 2, 3])->asyncMap($square)->asyncMap($square));

asyncMap_checkMapClass(Collection::fromIterable(['foo' => 'bar', 'bar' => 'baz'])->asyncMap($toClass));

// This should work but static analysers restrict the return type
// E.g: `numeric&string` or `non-empty-string`
/** @psalm-suppress InvalidArgument */
asyncMap_checkListString(Collection::fromIterable([1, 2, 3])->asyncMap($toString));
/** @psalm-suppress InvalidArgument */
asyncMap_checkMapString(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->asyncMap($appendBar));
/** @psalm-suppress InvalidArgument */
asyncMap_checkListString(Collection::fromIterable(['foo', 'bar'])->asyncMap($appendBar));
/** @psalm-suppress InvalidArgument */
asyncMap_checkListString(Collection::fromIterable([1, 2, 3])->asyncMap($square)->asyncMap($toString)->asyncMap($appendBar));

// VALID failures due to usage with wrong types

/** @psalm-suppress InvalidScalarArgument @phpstan-ignore-next-line */
asyncMap_checkListInt(Collection::fromIterable(['foo' => 'bar'])->asyncMap($square));
/** @psalm-suppress InvalidScalarArgument @phpstan-ignore-next-line */
asyncMap_checkMapString(Collection::fromIterable([1, 2, 3])->asyncMap($appendBar));
