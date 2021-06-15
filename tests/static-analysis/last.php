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
function last_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function last_checkMap(CollectionInterface $collection): void
{
}
function last_checkIntElement(int $value): void
{
}
function last_checkNullableInt(?int $value): void
{
}
function last_checkStringElement(string $value): void
{
}
function last_checkNullableString(?string $value): void
{
}

last_checkList(Collection::fromIterable([1, 2, 3])->last());
last_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->last());

last_checkList(Collection::empty()->last());
last_checkMap(Collection::empty()->last());

last_checkNullableInt(Collection::fromIterable([1, 2, 3])->last()->current());
last_checkNullableString(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->last()->current());

// This retrieval method doesn't cause static analysis complaints
// but is not always reliable because of that.
last_checkIntElement(Collection::fromIterable([1, 2, 3])->last()->all()[0]);
last_checkStringElement(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->last()->all()['foo']);
last_checkStringElement(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->last()->all()['baz']);

// VALID failures - `current` returns T|null
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
last_checkIntElement(Collection::fromIterable([1, 2, 3])->last()->current());
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
last_checkStringElement(Collection::fromIterable(['foo' => 'bar'])->last()->current());

// VALID failures - these keys don't exist
/** @psalm-suppress InvalidArrayOffset */
last_checkIntElement(Collection::fromIterable([1, 2, 3])->last()->all()[4]);
/** @psalm-suppress InvalidArrayOffset @phpstan-ignore-next-line */
last_checkStringElement(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->last()->all()[0]);
