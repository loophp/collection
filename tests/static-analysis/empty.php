<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

/**
 * @param Collection<int, int> $collection
 */
function checkNumeric(Collection $collection): void
{
}
/**
 * @param Collection<string, int> $collection
 */
function checkMap(Collection $collection): void
{
}

checkNumeric(Collection::empty());
checkMap(Collection::empty());
