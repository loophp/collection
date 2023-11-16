<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int<0,1>|float> $intOrFloat
 */
function takeIntOrFloat(CollectionInterface $intOrFloat): void {}

takeIntOrFloat(Collection::fromIterable(str_split('hello'))->entropy());
