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
 * @param CollectionInterface<int, array{0: int, 1: int}> $collection
 */
function pack_checkListInt(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, array{0: int, 1: string}> $collection
 */
function pack_checkListString(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, array{0: string, 1: string}> $collection
 */
function pack_checkListStringWithString(CollectionInterface $collection): void
{
}

pack_checkListInt(Collection::fromIterable([1, 2, 3])->pack());
pack_checkListString(Collection::fromIterable(range('a', 'b'))->pack());
pack_checkListStringWithString(Collection::fromIterable(array_combine(range('a', 'b'), range('a', 'b')))->pack());
