<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, list<array{0: int, 1: string}>> $collection
 */
function inits_checkListString(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, list<array{0: string, 1: string}>> $collection
 */
function inits_checkMapString(CollectionInterface $collection): void
{
}

$listString = range('a', 'c');
$mapString = array_combine(range('a', 'c'), range('a', 'c'));

inits_checkListString(Collection::fromIterable($listString)->inits());
inits_checkMapString(Collection::fromIterable($mapString)->inits());
