<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @psalm-param CollectionInterface<int<0, max>, int> $collection
 *
 * @phpstan-param CollectionInterface<int, int> $collection
 */
function fromGenerator_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, int> $collection
 */
function fromGenerator_checkMap(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, int|string> $collection
 */
function fromGenerator_checkMixed(CollectionInterface $collection): void
{
}

$generatorClosureList = static fn (): Generator => yield from range(1, 3);
$generatorClosureMap = static fn (): Generator => yield 'myKey' => 1;
$generatorClosureMixed = static function (): Generator {
    yield 1 => 2;

    yield 3 => 'b';

    yield 1 => 'c';

    yield 4 => '5';
};

fromGenerator_checkList(Collection::fromGenerator($generatorClosureList()));
fromGenerator_checkMap(Collection::fromGenerator($generatorClosureMap()));
fromGenerator_checkMixed(Collection::fromGenerator($generatorClosureMixed()));
