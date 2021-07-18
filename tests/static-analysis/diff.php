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
function diff_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function diff_checkMap(CollectionInterface $collection): void
{
}

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

// This is valid in PHP 8 but Psalm does not allow it (unpacking string keys)
/** @psalm-suppress InvalidArgument */
diff_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->diff(...Collection::fromIterable(['foo' => 'f'])));
/** @psalm-suppress InvalidArgument */
diff_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->diff(...(static fn (): Generator => yield 'bar' => 'b')()));
/** @psalm-suppress InvalidArgument */
diff_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->diff(...['foo' => 'f']));

// VALID failures -> usage with wrong types
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
diff_checkList(Collection::fromIterable([1, 2, 3])->diff('a'));
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
diff_checkList(Collection::fromIterable([1, 2, 3])->diff(1, 'a'));
/** @phpstan-ignore-next-line */
diff_checkList(Collection::fromIterable([1, 2, 3])->diff(...$stringCol));

/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
diff_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->diff(1));
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
diff_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->diff(1, 'f'));
/** @phpstan-ignore-next-line */
diff_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->diff(...$intCol));
