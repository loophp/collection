<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

$sum = static fn (int $carry, int $value): int => $carry + $value;
$concat = static fn (string $carry, string $string): string => sprintf('%s%s', $carry, $string);
$concatWithNull = static fn (?string $carry, string $string): string => sprintf('%s%s', (string) $carry, $string);
$toString =
    /**
     * @param bool|string $carry
     */
    static fn ($carry, int $value): string => sprintf('%s', $value);

/**
 * @param CollectionInterface<int, int> $collection
 */
function scanLeft_checkListInt(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, string> $collection
 */
function scanLeft_checkListString(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, string|null> $collection
 */
function scanLeft_checkListStringWithNull(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, bool|string> $collection
 */
function scanLeft_checkListOfSize1String(CollectionInterface $collection): void
{
}

scanLeft_checkListInt(Collection::fromIterable([1, 2, 3])->scanLeft($sum, 5));
scanLeft_checkListString(Collection::fromIterable(range('a', 'c'))->scanLeft($concat, ''));
scanLeft_checkListStringWithNull(Collection::fromIterable(range('a', 'c'))->scanLeft($concatWithNull));
scanLeft_checkListOfSize1String(Collection::fromIterable([10])->scanLeft($toString, true));
