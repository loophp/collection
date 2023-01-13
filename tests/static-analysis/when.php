<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @psalm-param CollectionInterface<int<0, max>, string> $collection
 *
 * @phpstan-param CollectionInterface<int, string> $collection
 */
function whenConditionIsTrueT_checkList(CollectionInterface $collection): void
{
}

/**
 * @psalm-param CollectionInterface<int<0, max>, int> $collection
 *
 * @phpstan-param CollectionInterface<int, int> $collection
 */
function whenConditionIsFalseT_checkList(CollectionInterface $collection): void
{
}

whenConditionIsTrueT_checkList(
    Collection::fromIterable(range('a', 'e'))
        ->when(
            static fn () => true,
            static fn () => range('a', 'e'),
            static fn () => range('a', 'e')
        )
);

whenConditionIsTrueT_checkList(
    Collection::fromIterable(range('a', 'e'))
        ->when(
            static fn () => true,
            static fn () => range('a', 'e')
        )
);

whenConditionIsFalseT_checkList(
    Collection::fromIterable(range(0, 4))
        ->when(
            static fn () => false,
            static fn () => range(0, 4),
            static fn () => range(0, 4)
        )
);
