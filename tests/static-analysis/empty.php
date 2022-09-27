<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function empty_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, int> $collection
 */
function empty_checkMap(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, int|string> $collection
 */
function empty_checkMixed(CollectionInterface $collection): void
{
}

empty_checkList(Collection::empty());
empty_checkMap(Collection::empty());
empty_checkMixed(Collection::empty());
