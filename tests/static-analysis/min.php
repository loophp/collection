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
function min_checkListInt(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, int|null> $collection
 */
function min_checkNullableListInt(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<string, string> $collection
 */
function min_checkMapString(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<string, string|null> $collection
 */
function min_checkMapNullableString(CollectionInterface $collection): void
{
}

min_checkListInt(Collection::empty()->min());
min_checkListInt(Collection::fromIterable([1, 2, 3, -2, 4])->min());

min_checkNullableListInt(Collection::empty()->min());
min_checkNullableListInt(Collection::fromIterable([1, 2, null, -2, 4])->min());

min_checkMapString(Collection::empty()->min());
min_checkMapString(Collection::fromIterable(['f' => 'foo', 'b' => 'bar'])->min());

min_checkMapNullableString(Collection::empty()->min());
min_checkMapNullableString(Collection::fromIterable(['f' => 'foo', 'b' => null])->min());
