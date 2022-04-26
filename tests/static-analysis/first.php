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
function first_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function first_checkMap(CollectionInterface $collection): void
{
}
function first_checkIntElement(int $value): void
{
}
function first_checkNullableInt(?int $value): void
{
}
function first_checkStringElement(string $value): void
{
}
function first_checkNullableString(?string $value): void
{
}

first_checkList(Collection::fromIterable([1, 2, 3])->first());
first_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->first());

first_checkList(Collection::empty()->first());
first_checkMap(Collection::empty()->first());

first_checkNullableInt(Collection::fromIterable([1, 2, 3])->first()->current());
first_checkNullableString(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->first()->current());

// This retrieval method doesn't cause static analysis complaints
// but is not always reliable because of that.
first_checkIntElement(Collection::fromIterable([1, 2, 3])->first()->all()[0]);
first_checkStringElement(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->first()->all(false)['foo']);
first_checkStringElement(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->first()->all(false)['baz']);

// VALID failures - `current` returns T|null
/** @psalm-suppress NullArgument @phpstan-ignore-next-line */
first_checkIntElement(Collection::fromIterable([1, 2, 3])->first()->current());
/** @psalm-suppress NullArgument @phpstan-ignore-next-line */
first_checkStringElement(Collection::fromIterable(['foo' => 'bar'])->first()->current());

// VALID failures - these keys don't exist
/** @psalm-suppress InvalidArrayOffset */
first_checkIntElement(Collection::fromIterable([1, 2, 3])->first()->all(false)[4]);
/** @psalm-suppress InvalidArrayOffset @phpstan-ignore-next-line */
first_checkStringElement(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->first()->all(false)[0]);
