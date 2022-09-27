<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function tail_checkListInt(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, string> $collection
 */
function tail_checkListString(CollectionInterface $collection): void
{
}

tail_checkListInt(Collection::fromIterable([1, 2, 3])->tail());
tail_checkListString(Collection::fromIterable(range('a', 'b'))->tail());
