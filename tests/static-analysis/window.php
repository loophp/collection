<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, list<int>> $collection
 */
function window_checkListInt(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, list<string>> $collection
 */
function window_checkListString(CollectionInterface $collection): void
{
}

window_checkListInt(Collection::fromIterable([1, 2, 3])->window(1));
window_checkListString(Collection::fromIterable(range('a', 'b'))->window(2));
