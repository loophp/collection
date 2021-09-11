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
function head_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function head_checkMap(CollectionInterface $collection): void
{
}
function head_checkIntElement(int $value): void
{
}
function head_checkNullableInt(?int $value): void
{
}
function head_checkStringElement(string $value): void
{
}
function head_checkNullableString(?string $value): void
{
}

head_checkList(Collection::fromIterable([1, 2, 3])->head());
head_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->head());

head_checkList(Collection::empty()->head());
head_checkMap(Collection::empty()->head());

head_checkNullableInt(Collection::fromIterable([1, 2, 3])->head()->current());
head_checkNullableString(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->head()->current());

// This retrieval method doesn't cause static analysis complaints
// but is not always reliable because of that.
head_checkIntElement(Collection::fromIterable([1, 2, 3])->head()->all()[0]);
head_checkStringElement(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->head()->all()['foo']);
head_checkStringElement(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->head()->all()['baz']);

// VALID failures - `current` returns T|null
/** @psalm-suppress NullArgument @phpstan-ignore-next-line */
head_checkIntElement(Collection::fromIterable([1, 2, 3])->head()->current());
/** @psalm-suppress NullArgument @phpstan-ignore-next-line */
head_checkStringElement(Collection::fromIterable(['foo' => 'bar'])->head()->current());

// VALID failures - these keys don't exist
/** @psalm-suppress InvalidArrayOffset */
head_checkIntElement(Collection::fromIterable([1, 2, 3])->head()->all()[4]);
/** @psalm-suppress InvalidArrayOffset @phpstan-ignore-next-line */
head_checkStringElement(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->head()->all()[0]);
