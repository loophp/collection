<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\CollectionT;

/**
 * @param array<int, int> $array
 */
function allT_checkList(array $array): void
{
}
/**
 * @param array<string, int> $array
 */
function allT_checkMap(array $array): void
{
}
/**
 * @param array<int, int|string> $array
 */
function allT_checkMixed(array $array): void
{
}

allT_checkList(CollectionT::empty()->all());
allT_checkMap(CollectionT::empty()->all());
allT_checkMixed(CollectionT::empty()->all());

allT_checkList(CollectionT::fromIterable([1, 2, 3])->all());
allT_checkMap(CollectionT::fromIterable(['foo' => 1, 'bar' => 2])->all());
allT_checkMixed(CollectionT::fromIterable([1, 2, 'b', '5', 4])->all());
