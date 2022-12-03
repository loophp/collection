<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @phpstan-param CollectionInterface<int, array<int, int>> $collection
 * @psalm-param CollectionInterface<int, array<int, int<0, max>>> $collection
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

$intIntGenerator = static function (): Generator {
    yield random_int(0, mt_getrandmax());
};

$stringBoolGenerator = static function (): Generator {
    yield chr(random_int(0, 255)) => 0 === random_int(0, mt_getrandmax()) % 2;
};

wrap_checkList(Collection::fromIterable($intIntGenerator())->wrap());
wrap_checkMap(Collection::fromIterable($stringBoolGenerator())->wrap());
