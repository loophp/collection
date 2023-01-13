<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @phpstan-param CollectionInterface<int, int> $collection
 *
 * @psalm-param CollectionInterface<int<0, max>, int> $collection
 */
function unpack_checkListInt(CollectionInterface $collection): void
{
}

/**
 * @phpstan-param CollectionInterface<int, string> $collection
 *
 * @psalm-param CollectionInterface<int<0, max>, string> $collection
 */
function unpack_checkListString(CollectionInterface $collection): void
{
}

/**
 * @phpstan-param CollectionInterface<string, string> $collection
 */
function unpack_checkListStringWithString(CollectionInterface $collection): void
{
}

unpack_checkListInt(Collection::fromIterable(range(0, 5))->unpack());
unpack_checkListString(Collection::fromIterable(range('a', 'c'))->unpack());
unpack_checkListStringWithString(Collection::fromIterable(array_combine(range('a', 'c'), range('a', 'c')))->unpack());
