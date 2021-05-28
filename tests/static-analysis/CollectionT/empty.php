<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\CollectionT;

/**
 * @param CollectionT<int, int> $collection
 */
function emptyT_checkList(CollectionT $collection): void
{
}
/**
 * @param CollectionT<string, int> $collection
 */
function emptyT_checkMap(CollectionT $collection): void
{
}
/**
 * @param CollectionT<int, int|string> $collection
 */
function emptyT_checkMixed(CollectionT $collection): void
{
}

emptyT_checkList(CollectionT::empty());
emptyT_checkMap(CollectionT::empty());
emptyT_checkMixed(CollectionT::empty());
