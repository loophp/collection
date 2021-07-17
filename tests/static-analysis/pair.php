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
 * @param CollectionInterface<int, int|null> $collection
 */
function pair_checkListInt(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<string, string|null> $collection
 */
function pair_checkListString(CollectionInterface $collection): void
{
}

pair_checkListInt(Collection::fromIterable([1, 2, 3])->pair());
pair_checkListString(Collection::fromIterable(range('a', 'b'))->pair());
