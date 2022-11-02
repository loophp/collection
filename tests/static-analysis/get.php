<?php

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
function get_checkListNullable(?int $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function get_checkMap(CollectionInterface $collection): void
{
}
function get_checkMapNullable(?string $collection): void
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

get_checkNullableInt(Collection::fromIterable([1, 2, 3])->get(1));
get_checkNullableString(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->get('foo'));

// These SHOULD work because the default parameter can be any value or type,
// but PHPStan doesn't like it:
// "Parameter #1 $collection of function get_checkListNullable expects loophp\collection\Contract\Collection<int, int|null>,
// loophp\collection\Contract\Collection<int, int> given."
get_checkListNullable(Collection::fromIterable([1, 2, 3])->get(1, -1));
get_checkMapNullable(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->get('foo', 'x'));

// VALID failures - `get` returns `Collection<TKey, T|V>, where V can be anything
/** @psalm-suppress InvalidArgument */
get_checkList(Collection::fromIterable([1, 2, 3])->get(1));
/** @psalm-suppress InvalidArgument */
get_checkMap(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->get('foo'));

// VALID failures - `current` can return `NULL`
/** @psalm-suppress PossiblyNullArgument */
get_checkIntElement(Collection::fromIterable([1, 2, 3])->get(1));
/** @psalm-suppress PossiblyNullArgument */
get_checkStringElement(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->get('foo'));

// VALID but inconvenient failures - although a non-null default is provided to `get`, `current` can return `NULL`
get_checkIntElement(Collection::fromIterable([1, 2, 3])->get(1, 2));
get_checkStringElement(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->get('foo', 'a'));
