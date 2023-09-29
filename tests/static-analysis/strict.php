<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @psalm-param CollectionInterface<int<0, 2>, 1|2|3> $collection
 *
 * @phpstan-param CollectionInterface<int, int> $collection
 */
function strict_checkList(CollectionInterface $collection): void {}
/**
 * @param CollectionInterface<string, string> $collection
 */
function strict_checkMap(CollectionInterface $collection): void {}

$callback = static fn (mixed $value): string => gettype($value);

strict_checkList(Collection::fromIterable([1, 2, 3])->strict());
strict_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->strict());

strict_checkList(Collection::fromIterable([1, 2, 3])->strict($callback));
strict_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->strict($callback));
