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
 * @param CollectionInterface<int, list<int>> $collection
 */
function tails_checkListInt(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, list<string>> $collection
 */
function tails_checkListString(CollectionInterface $collection): void
{
}

tails_checkListInt(Collection::fromIterable([1, 2, 3])->tails());
tails_checkListString(Collection::fromIterable(range('a', 'b'))->tails());
