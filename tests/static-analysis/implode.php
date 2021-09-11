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
 * @param CollectionInterface<int, string> $collection
 */
function implode_checkListString(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<string, string> $collection
 */
function implode_checkMapInt(CollectionInterface $collection): void
{
}

$input = range('a', 'e');

implode_checkListString(Collection::fromIterable($input)->implode(','));
implode_checkMapInt(Collection::fromIterable(array_combine($input, $input))->implode(','));
