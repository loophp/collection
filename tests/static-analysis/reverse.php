<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function reverse_checkList(CollectionInterface $collection): void
{
}

reverse_checkList(Collection::fromIterable(range(0, 5))->reverse());
