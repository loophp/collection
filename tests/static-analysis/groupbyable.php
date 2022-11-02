<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, non-empty-list<string>> $collection
 */
function groupby_sameKeyType(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<string, non-empty-list<string>> $collection
 */
function groupby_newKeyType(CollectionInterface $collection): void
{
}

$foo = [
    0 => 'foo',
    1 => 'bar',
    2 => 'baz',
];

groupby_sameKeyType(
    Collection::fromIterable($foo)->groupBy(static fn (string $value, int $key): int => $key)
);

groupby_newKeyType(
    Collection::fromIterable($foo)->groupBy(static fn (string $value): string => $value)
);

// VALID failure -> invalid key types
/** @psalm-suppress InvalidArgument */
Collection::fromIterable($foo)->groupBy(static fn () => null);
/** @psalm-suppress InvalidArgument */
Collection::fromIterable($foo)->groupBy(static fn (): stdClass => new stdClass());
