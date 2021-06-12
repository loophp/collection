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
function chunk_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, list<string>> $collection
 */
function chunk_checkMap(CollectionInterface $collection): void
{
}

chunk_checkList(Collection::fromIterable(range(0, 6))->chunk(1));
chunk_checkList(Collection::fromIterable(range(0, 6))->chunk(1, 2));

// These should work but Psalm restricts type to list<'baz'|'taz'>
/** @psalm-suppress InvalidArgument */
chunk_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => 'taz'])->chunk(1));
/** @psalm-suppress InvalidArgument */
chunk_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => 'taz'])->chunk(0, 1));
