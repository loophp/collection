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
 * @param CollectionInterface<int, bool> $collection
 */
function contains_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, bool> $collection
 */
function contains_checkMap(CollectionInterface $collection): void
{
}
function contains_checkBool(bool $value): void
{
}

contains_checkList(Collection::fromIterable([1, 2, 3])->contains(2));
contains_checkList(Collection::fromIterable(range(1, 3))->contains(2, 4));

contains_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => 'taz'])->contains('bar'));
/** @psalm-suppress InvalidArgument -> Psalm is smart and knows that 'abc' cannot be in there */
contains_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => 'taz'])->contains('bar', 'abc'));

// VALID failures below -> `current` can return `NULL` if the collection is empty

/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
contains_checkBool(Collection::fromIterable([1, 2, 3])->contains(2)->current());
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
contains_checkBool(Collection::fromIterable(['foo' => 'bar', 'baz' => 'taz'])->contains('bar')->current());

// explicit check is needed for PHPStan because the value is of type `bool|null`
if (true === Collection::fromIterable([1, 2, 3])->contains(2)->current()) {
}
