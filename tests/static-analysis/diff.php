<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @phpstan-param CollectionInterface<int, int> $collection
 *
 * @psalm-param CollectionInterface|CollectionInterface<int<0, 2>, 0|1|2> $collection
 */
function diff_checkList(CollectionInterface $collection): void {}
/**
 * @param CollectionInterface<string, string> $collection
 */
function diff_checkMap(CollectionInterface $collection): void {}

$intGen = static fn (): Generator => yield from [2, 3];
$intCol = Collection::fromIterable([2, 3]);

$stringGen = static fn (): Generator => yield 'b';
$stringCol = Collection::fromIterable(['b']);

diff_checkList(Collection::fromIterable([1, 2, 3])->diff(1));
diff_checkList(Collection::fromIterable([1, 2, 3])->diff(1, 2));
diff_checkList(Collection::fromIterable([1, 2, 3])->diff(...[1, 2]));
diff_checkList(Collection::fromIterable([1, 2, 3])->diff(...$intGen()));
diff_checkList(Collection::fromIterable([1, 2, 3])->diff(...$intCol));

diff_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->diff('f'));
diff_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->diff('f', 'b'));
diff_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->diff(...['f']));
diff_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->diff(...$stringGen()));
diff_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->diff(...$stringCol));

diff_checkList(Collection::fromIterable([1, 2, 3])->diff(...$stringCol));
diff_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->diff(1, 'f'));
diff_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->diff(...$intCol));

// This is valid in PHP 8 but Psalm does not allow it (unpacking string keys)
/** @psalm-suppress InvalidArgument */
diff_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->diff(...Collection::fromIterable(['foo' => 'f'])));
/** @psalm-suppress InvalidArgument */
diff_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->diff(...(static fn (): Generator => yield 'bar' => 'b')()));

diff_checkList(Collection::fromIterable([1, 2, 3])->diff(...$stringCol));
diff_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->diff(...$intCol));

// VALID failures -> usage with wrong types
/** @psalm-suppress InvalidArgument */
diff_checkList(Collection::fromIterable([1, 2, 3])->diff('a'));
/** @psalm-suppress InvalidArgument */
diff_checkList(Collection::fromIterable([1, 2, 3])->diff(1, 'a'));

/** @psalm-suppress InvalidArgument */
diff_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->diff(1));
/** @psalm-suppress InvalidArgument */
diff_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->diff(1, 'f'));
