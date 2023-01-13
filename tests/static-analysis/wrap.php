<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @phpstan-param CollectionInterface<int, array<int, int>> $collection
 *
 * @psalm-param CollectionInterface<int, array<int<0, max>, int>> $collection
 */
function wrap_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, array<string, bool>> $collection
 */
function wrap_checkMap(CollectionInterface $collection): void
{
}

wrap_checkList(Collection::fromIterable(range(0, 3))->wrap());
wrap_checkMap(Collection::fromIterable(['a' => true, 'b' => false])->wrap());
