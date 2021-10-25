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
function get_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, int|null> $collection
 */
function get_checkListNullable(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function get_checkMap(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string|null> $collection
 */
function get_checkMapNullable(CollectionInterface $collection): void
{
}
function get_checkIntElement(int $value): void
{
}
function get_checkNullableInt(?int $value): void
{
}
function get_checkStringElement(string $value): void
{
}
function get_checkNullableString(?string $value): void
{
}

get_checkListNullable(Collection::fromIterable([1, 2, 3])->get(1));
get_checkMapNullable(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->get('foo'));

get_checkNullableInt(Collection::fromIterable([1, 2, 3])->get(1)->current());
get_checkNullableString(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->get('foo')->current());

// These SHOULD work because the default parameter can be any value or type,
// but PHPStan doesn't like it:
// "Parameter #1 $collection of function get_checkListNullable expects loophp\collection\Contract\Collection<int, int|null>,
// loophp\collection\Contract\Collection<int, int> given."
/** @phpstan-ignore-next-line */
get_checkListNullable(Collection::fromIterable([1, 2, 3])->get(1, -1));
/** @phpstan-ignore-next-line */
get_checkMapNullable(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->get('foo', 'x'));

// VALID failures - `get` returns `Collection<TKey, T|V>, where V can be anything
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
get_checkList(Collection::fromIterable([1, 2, 3])->get(1));
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
get_checkMap(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->get('foo'));

// VALID failures - `current` can return `NULL`
/** @psalm-suppress NullArgument @phpstan-ignore-next-line */
get_checkIntElement(Collection::fromIterable([1, 2, 3])->get(1)->current());
/** @psalm-suppress NullArgument @phpstan-ignore-next-line */
get_checkStringElement(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->get('foo')->current());

// VALID but inconvenient failures - although a non-null default is provided to `get`, `current` can return `NULL`
/** @psalm-suppress NullArgument @phpstan-ignore-next-line */
get_checkIntElement(Collection::fromIterable([1, 2, 3])->get(1, 2)->current());
/** @psalm-suppress NullArgument @phpstan-ignore-next-line */
get_checkStringElement(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->get('foo', 'a')->current());
