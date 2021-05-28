<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__.'/../../../vendor/autoload.php';

use loophp\collection\Collection;

/**
 * @param Collection<int, int> $collection
 */
function empty_checkNumeric(Collection $collection): void
{
}
/**
 * @param Collection<string, int> $collection
 */
function empty_checkMap(Collection $collection): void
{
}
/**
 * @param Collection<int, int|string> $collection
 */
function empty_checkMixed(Collection $collection): void
{
}

empty_checkNumeric(Collection::empty());
empty_checkMap(Collection::empty());
empty_checkMixed(Collection::empty());
