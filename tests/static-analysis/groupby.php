<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @psalm-param CollectionInterface<int<0, 2>, non-empty-list<'bar'|'baz'|'foo'>> $collection
 *
 * @phpstan-param CollectionInterface<int, non-empty-array<int, string>> $collection
 */
function groupby_sameKeyType(CollectionInterface $collection): void
{
}

/**
 * @psalm-param CollectionInterface<string, non-empty-list<string>> $collection
 *
 * @phpstan-param CollectionInterface<string, non-empty-array<int, string>> $collection
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
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
Collection::fromIterable($foo)->groupBy(static fn () => null);
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
Collection::fromIterable($foo)->groupBy(static fn (): stdClass => new stdClass());
