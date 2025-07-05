<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @phpstan-param CollectionInterface<int, list<int>> $collection
 *
 * @psalm-param CollectionInterface<int<0, 2>, list<1|2|3>> $collection
 */
function window_checkListInt(CollectionInterface $collection): void {}

/**
 * @phpstan-param CollectionInterface<int, list<string>> $collection
 *
 * @psalm-param CollectionInterface<int<0, max>, list<string>> $collection
 */
function window_checkListString(CollectionInterface $collection): void {}

window_checkListInt(Collection::fromIterable([1, 2, 3])->window(1));
window_checkListString(Collection::fromIterable(range('a', 'b'))->window(2));
