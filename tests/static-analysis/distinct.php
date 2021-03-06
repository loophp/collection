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
function distinct_checkIntList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, stdClass> $collection
 */
function distinct_checkObjectList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function distinct_checkMap(CollectionInterface $collection): void
{
}

$cat = static function (string $name): stdClass {
    $instance = new stdClass();
    $instance->name = $name;

    return $instance;
};

$cats = [
    $cat1 = $cat('izumi'),
    $cat2 = $cat('nakano'),
    $cat3 = $cat('booba'),
    $cat3,
];

$accessor = static fn (stdClass $object): string => $object->name;
$stringComparator = static fn (string $left): Closure => static fn (string $right): bool => $left === $right;
$objectComparator = static fn (stdClass $left): Closure => static fn (stdClass $right): bool => $left->name === $right->name;

distinct_checkIntList(Collection::fromIterable([11, 12, 11, 13])->distinct());
distinct_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b', 'baz' => 'f'])->distinct());

distinct_checkObjectList(Collection::fromIterable($cats)->distinct());
distinct_checkObjectList(Collection::fromIterable($cats)->distinct($objectComparator));
distinct_checkObjectList(Collection::fromIterable($cats)->distinct($stringComparator, $accessor));
distinct_checkObjectList(Collection::fromIterable($cats)->distinct(null, $accessor));

// VALID failures

// `distinct` does not change the collection types TKey, T
/** @psalm-suppress InvalidScalarArgument @phpstan-ignore-next-line */
distinct_checkIntList(Collection::fromIterable(['a', 'b', 'c'])->distinct());
/** @psalm-suppress InvalidScalarArgument @phpstan-ignore-next-line */
distinct_checkMap(Collection::fromIterable(['foo' => 1, 'bar' => 2, 'baz' => 'f'])->distinct());

// mixing object comparator parameter types
$objectComparator = static fn (stdClass $left): Closure => static fn (string $right): bool => $left->name === $right;
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
distinct_checkObjectList(Collection::fromIterable($cats)->distinct($objectComparator));

// using wrong type parameter for accessor callback
$accessor = static fn (string $object): string => $object;
/** @psalm-suppress InvalidArgument */
distinct_checkObjectList(Collection::fromIterable($cats)->distinct(null, $accessor));

// comparator parameter types need to match accessor return type
$accessor = static fn (stdClass $object): string => $object->name;
$objectComparator = static fn (stdClass $left): Closure => static fn (stdClass $right): bool => $left->name === $right->name;
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
distinct_checkObjectList(Collection::fromIterable($cats)->distinct($objectComparator, $accessor));
