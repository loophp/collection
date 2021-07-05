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
 * @param CollectionInterface<int, int> $collection
 */
function strict_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function strict_checkMap(CollectionInterface $collection): void
{
}

$callback =
    /** @param mixed $value */
    static fn ($value): string => gettype($value);

strict_checkList(Collection::fromIterable([1, 2, 3])->strict());
strict_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->strict());

strict_checkList(Collection::fromIterable([1, 2, 3])->strict($callback));
strict_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->strict($callback));
