<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;
use tests\loophp\collection\NamedItem;

/**
 * @psalm-param CollectionInterface<int<0, 3>, 11|12|13> $collection
 *
 * @phpstan-param CollectionInterface<int, int> $collection
 */
function distinct_checkIntList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, NamedItem> $collection
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

// TODO: Replace with a proper typed generator when it will be done.
$catGenerator =
    /**
     * @return Generator<int, NamedItem>
     */
    static function (): Generator {
        $names = ['izumi', 'nakano', 'booba'];

        // @phpstan-ignore-next-line
        while (true) {
            yield new NamedItem($names[array_rand($names)]);
        }
    };

$accessor = static fn (NamedItem $object): string => $object->name();
$stringComparator = static fn (string $left): Closure => static fn (string $right): bool => $left === $right;
$objectComparator = static fn (NamedItem $left): Closure => static fn (NamedItem $right): bool => $left->name() === $right->name();

distinct_checkIntList(Collection::fromIterable([11, 12, 11, 13])->distinct());
distinct_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b', 'baz' => 'f'])->distinct());

distinct_checkObjectList(Collection::fromIterable($catGenerator())->distinct());
distinct_checkObjectList(Collection::fromIterable($catGenerator())->distinct($objectComparator));
distinct_checkObjectList(Collection::fromIterable($catGenerator())->distinct($stringComparator, $accessor));
distinct_checkObjectList(Collection::fromIterable($catGenerator())->distinct(null, $accessor));

// VALID failures

// `distinct` does not change the collection types TKey, T
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
distinct_checkIntList(Collection::fromIterable(['a', 'b', 'c'])->distinct());
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
distinct_checkMap(Collection::fromIterable(['foo' => 1, 'bar' => 2, 'baz' => 'f'])->distinct());

// mixing object comparator parameter types
$objectComparator = static fn (NamedItem $left): Closure => static fn (string $right): bool => $left->name() === $right;
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
distinct_checkObjectList(Collection::fromIterable($catGenerator())->distinct($objectComparator));

// using wrong type parameter for accessor callback
$accessor = static fn (string $object): string => $object;
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
distinct_checkObjectList(Collection::fromIterable($catGenerator())->distinct(null, $accessor));

// comparator parameter types need to match accessor return type
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
distinct_checkObjectList(Collection::fromIterable($catGenerator())->distinct($objectComparator, $accessor));
