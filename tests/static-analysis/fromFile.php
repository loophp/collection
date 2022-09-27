<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, string> $collection
 */
function fromFile_check(CollectionInterface $collection): void
{
}

fromFile_check(Collection::fromFile('https://loripsum.net/api')->limit(25));
