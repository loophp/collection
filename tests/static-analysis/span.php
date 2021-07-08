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
 * @param CollectionInterface<int, CollectionInterface<int, int>> $collection
 */
function span_checkListCollectionInt(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, int> $collection
 */
function span_checkListInt(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, CollectionInterface<string, string>> $collection
 */
function span_checkMapCollectionString(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function span_checkMapString(CollectionInterface $collection): void
{
}

$intValueCallback = static fn (int $value): bool => $value % 2 === 0;
$stringValueCallback = static fn (string $value): bool => 'bar' === $value;

span_checkListCollectionInt(Collection::fromIterable([2, 3, 4])->span($intValueCallback));
span_checkMapCollectionString(Collection::fromIterable(['foo' => 'bar', 'bar' => 'foo'])->span($stringValueCallback));

[$left, $right] = Collection::fromIterable([2, 3, 4])->span($intValueCallback)->all();
span_checkListInt($left);
span_checkListInt($right);

$first = Collection::fromIterable([2, 3, 4])->span($intValueCallback)->first();
$last = Collection::fromIterable([2, 3, 4])->span($intValueCallback)->last();
span_checkListCollectionInt($first);
span_checkListCollectionInt($last);

// VALID failures -> current returns T|null

/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
span_checkListInt($first->current());
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
span_checkListInt($last->current());

[$left, $right] = Collection::fromIterable(['foo' => 'bar', 'bar' => 'foo'])->span($stringValueCallback)->all();
span_checkMapString($left);
span_checkMapString($right);

$first = Collection::fromIterable(['foo' => 'bar', 'bar' => 'foo'])->span($stringValueCallback)->first();
$last = Collection::fromIterable(['foo' => 'bar', 'bar' => 'foo'])->span($stringValueCallback)->last();
span_checkMapCollectionString($first);
span_checkMapCollectionString($last);

// VALID failures -> current returns T|null

/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
span_checkMapString($first->current());
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
span_checkMapString($last->current());
