<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use Doctrine\Common\Collections\Criteria;
use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function matching_checkListInt(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, string> $collection
 */
function matching_checkListString(CollectionInterface $collection): void
{
}

$criteria = Criteria::create()->where(Criteria::expr()->gt('age', 18));

matching_checkListInt(Collection::fromIterable([1, 2, 3])->matching($criteria));
matching_checkListInt(Collection::fromIterable([1, 2, 3])->matching($criteria)->matching($criteria));

matching_checkListString(Collection::fromIterable(range('a', 'e'))->matching($criteria));
matching_checkListString(Collection::fromIterable(range('a', 'e'))->matching($criteria)->matching($criteria));
