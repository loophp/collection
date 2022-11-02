<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function append_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, array<string, int>> $collection
 */
function append_checkListWithMap(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, int> $collection
 */
function append_checkMap(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int|string, int|string> $collection
 */
function append_checkMixed(CollectionInterface $collection): void
{
}

// Annotations are NOT needed most of the time because Collection only allows appending
// items that are of the same type as those already contained in the collection.
//
// Note that analysers can behave slightly differently, notably PHPStan does not consider
// multiple parameters passed too append() as potentially part of a union type.

// ## SUCCESS ###
append_checkList(Collection::empty()->append(1));
append_checkList(Collection::empty()->append(1, 2));
append_checkList(Collection::empty()->append(...[1, 2]));
append_checkList(Collection::fromIterable([5])->append(2));
append_checkList(Collection::fromIterable([5])->append(1, 2));
append_checkList(Collection::fromIterable([5])->append(...[1, 2]));

// Analysers sometime need to know the type of the first item in the collection or the appended one
// otherwise they might narrow it down too much, i.e. only allow array{foo: int} or array{bar: 2}
/** @var array<string, int> $foo */
$foo = ['foo' => 1];
/** @var array<string, int> $bar */
$bar = ['bar' => 2];
append_checkListWithMap(Collection::empty()->append($foo));
append_checkListWithMap(Collection::empty()->append($foo, ['bar' => 2]));
append_checkListWithMap(Collection::empty()->append(...[$foo, $bar]));
append_checkListWithMap(Collection::fromIterable([1 => $foo])->append($bar));

// These should work but they don't due to the way analysers interpret empty()
// or variadic parameters of different types passed to append()
/** @psalm-suppress InvalidArgument */
append_checkMixed(Collection::empty()->append(1, '2'));
/** @psalm-suppress InvalidArgument */
append_checkMixed(Collection::empty()->append(...[1, '2']));
append_checkMixed(Collection::fromIterable(['foo' => 1, 'bar' => '2'])->append(1, '3'));

// ## VALID FAILURE ###
/** @psalm-suppress InvalidArgument */
append_checkList(Collection::empty()->append(1, 'foo'));
/** @psalm-suppress InvalidScalarArgument */
append_checkList(Collection::fromIterable([5])->append('foo')); // @phpstan-ignore-line
/** @psalm-suppress InvalidScalarArgument */
append_checkList(Collection::fromIterable([5])->append('foo', 1)); // @phpstan-ignore-line

/** @psalm-suppress InvalidArgument */
append_checkListWithMap(Collection::empty()->append($foo, ['bar' => 'baz']));
/** @psalm-suppress InvalidScalarArgument @phpstan-ignore-next-line */
append_checkListWithMap(Collection::fromIterable([1 => $foo])->append(['bar' => 'baz']));

/**
 * Append will transform any Collection<string, int> into Collection<int|TKey, int>.
 *
 * @psalm-suppress InvalidScalarArgument
 *
 * @phpstan-ignore-next-line
 */
append_checkMap(Collection::fromIterable($foo)->append(3));

/** @psalm-suppress InvalidArgument */
append_checkMixed(Collection::empty()->append(1, [3]));
/** @psalm-suppress InvalidArgument */
append_checkMixed(Collection::empty()->append(...[1, [3]]));
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
append_checkMixed(Collection::fromIterable(['foo' => 1, 'bar' => '2'])->append(1, ['3']));
