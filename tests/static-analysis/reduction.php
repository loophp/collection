<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

$sum = static fn (int $carry, int $value): int => $carry + $value;
$concat = static fn (?string $carry, string $string): string => sprintf('%s%s', (string) $carry, $string);

/**
 * @psalm-param CollectionInterface|CollectionInterface<int<0, 2>, int> $collection
 *
 * @phpstan-param CollectionInterface<int, int> $collection
 */
function reduction_checkListInt(CollectionInterface $collection): void {}

/**
 * @psalm-param CollectionInterface|CollectionInterface<int<0, max>, string> $collection
 *
 * @phpstan-param CollectionInterface<int, string> $collection
 */
function reduction_checkListString(CollectionInterface $collection): void {}

/**
 * @param CollectionInterface<int, ?string> $collection
 */
function reduction_checkListStringWithNull(CollectionInterface $collection): void {}

reduction_checkListInt(Collection::fromIterable([1, 2, 3])->reduction($sum, 5));
reduction_checkListString(Collection::fromIterable(range('a', 'c'))->reduction($concat, ''));
reduction_checkListStringWithNull(Collection::fromIterable(range('a', 'c'))->reduction($concat));
