<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

function count_check(int $count): void
{
}

$counter = 0;

Collection::fromIterable(range(0, 6))->countIn($counter);

count_check($counter);

/**
 * @psalm-param CollectionInterface<int<0, 2>, int> $collection
 *
 * @phpstan-param CollectionInterface<int, int> $collection
 */
function checkListInt(CollectionInterface $collection): void
{
}

checkListInt(Collection::fromIterable([1, 2, 3])->countIn($counter));
