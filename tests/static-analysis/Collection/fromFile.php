<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__.'/../../../vendor/autoload.php';

use loophp\collection\Collection;

/**
 * @param Collection<int, string> $collection
 */
function fromFile_check(Collection $collection): void
{
}

fromFile_check(Collection::fromFile('https://loripsum.net/api')->limit(25));
