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
 * @param CollectionInterface<int, list<int|string>> $collection
 */
function product_checkList(CollectionInterface $collection): void
{
}

$input = range('a', 'e');
$productWith = range(1, 5);

product_checkList(Collection::fromIterable($input)->product($productWith));
