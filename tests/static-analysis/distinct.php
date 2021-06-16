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
function distinct_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function distinct_checkMap(CollectionInterface $collection): void
{
}
function distinct_checkIntElement(int $value): void
{
}
function distinct_checkNullableInt(?int $value): void
{
}
function distinct_checkStringElement(string $value): void
{
}
function distinct_checkNullableString(?string $value): void
{
}

distinct_checkList(Collection::fromIterable([1, 2, 3, 1])->distinct());
distinct_checkMap(Collection::fromIterable(['a' => 'foo', 'b' => 'bar', 'c' => 'baz', 'd' => 'bar'])->distinct());

distinct_checkList(Collection::empty()->distinct());
distinct_checkMap(Collection::empty()->distinct());

distinct_checkNullableInt(Collection::fromIterable([1, 2, 3, 1])->distinct()->current());
distinct_checkNullableString(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->head()->current());

// This retrieval method doesn't cause static analysis complaints
// but is not always reliable because of that.
distinct_checkIntElement(Collection::fromIterable([1, 2, 3, 1])->distinct()->all()[0]);
distinct_checkStringElement(Collection::fromIterable(['a' => 'foo', 'b' => 'bar', 'c' => 'baz', 'd' => 'bar'])->distinct()->all()['a']);
distinct_checkStringElement(Collection::fromIterable(['a' => 'foo', 'b' => 'bar', 'c' => 'baz', 'd' => 'bar'])->distinct()->all()['b']);

// VALID failures - `current` returns T|null
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
distinct_checkIntElement(Collection::fromIterable([1, 2, 3, 1])->distinct()->current());
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
distinct_checkStringElement(Collection::fromIterable(['foo' => 'bar', 'bar'])->distinct()->current());

// VALID failures - these keys don't exist
/** @psalm-suppress InvalidArrayOffset */
distinct_checkIntElement(Collection::fromIterable([1, 2, 3, 1])->distinct()->all()[4]);
/** @psalm-suppress InvalidArrayOffset @phpstan-ignore-next-line */
distinct_checkStringElement(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->distinct()->all()['plop']);
