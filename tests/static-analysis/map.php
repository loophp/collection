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
function map_checkListInt(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, string> $collection
 */
function map_checkListString(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function map_checkMapString(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, stdClass> $collection
 */
function map_checkMapClass(CollectionInterface $collection): void
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

map_checkListInt(Collection::fromIterable([1, 2, 3])->map($square));
map_checkListInt(Collection::fromIterable([1, 2, 3])->map($square)->map($square));

map_checkMapClass(Collection::fromIterable(['foo' => 'bar', 'bar' => 'baz'])->map($toClass));

// This should work but static analysers restrict the return type
// E.g: `numeric&string` or `non-empty-string`
/** @psalm-suppress InvalidArgument */
map_checkListString(Collection::fromIterable([1, 2, 3])->map($toString));
/** @psalm-suppress InvalidArgument */
map_checkMapString(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->map($appendBar));
/** @psalm-suppress InvalidArgument */
map_checkListString(Collection::fromIterable(['foo', 'bar'])->map($appendBar));
/** @psalm-suppress InvalidArgument */
map_checkListString(Collection::fromIterable([1, 2, 3])->map($square)->map($toString)->map($appendBar));

// VALID failures due to usage with wrong types

/**
 * @psalm-suppress InvalidArgument
 * @psalm-suppress InvalidScalarArgument
 *
 * @phpstan-ignore-next-line
 */
map_checkListInt(Collection::fromIterable(['foo' => 'bar'])->map($square));
/**
 * @psalm-suppress InvalidArgument
 * @psalm-suppress InvalidScalarArgument
 *
 * @phpstan-ignore-next-line
 */
map_checkMapString(Collection::fromIterable([1, 2, 3])->map($appendBar));
