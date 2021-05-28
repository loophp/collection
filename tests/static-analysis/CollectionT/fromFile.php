<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__.'/../../../vendor/autoload.php';

use loophp\collection\CollectionT;

/**
 * @param CollectionT<int, string> $collection
 */
function fromFileT_check(CollectionT $collection): void
{
}

fromFileT_check(CollectionT::fromFile('https://loripsum.net/api'));
