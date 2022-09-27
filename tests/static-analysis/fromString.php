<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, string> $collection
 */
function fromString_check(CollectionInterface $collection): void
{
}

fromString_check(Collection::fromString('hello world', ' '));
