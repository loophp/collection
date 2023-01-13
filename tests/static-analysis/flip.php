<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @phpstan-param CollectionInterface<int, int> $collection
 *
 * @psalm-param CollectionInterface<int, int<0, max>> $collection
 */
function flip_checkIntInt(CollectionInterface $collection): void
{
}
/**
 * @phpstan-param CollectionInterface<string, int> $collection
 *
 * @psalm-param CollectionInterface<string, int<0, max>> $collection
 */
function flip_checkStringInt(CollectionInterface $collection): void
{
}
/**
 * @phpstan-param CollectionInterface<int, string> $collection
 *
 * @psalm-param CollectionInterface<int<0, max>, string> $collection
 */
function flip_checkIntString(CollectionInterface $collection): void
{
}

flip_checkIntInt(Collection::fromIterable(range(0, 3))->flip());
flip_checkStringInt(Collection::fromIterable(range('a', 'c'))->flip());
flip_checkIntString(Collection::fromIterable(range('a', 'c'))->flip()->flip());
