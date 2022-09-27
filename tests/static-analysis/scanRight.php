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
function scanRight_checkListInt(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, string> $collection
 */
function scanRight_checkListString(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, string|null> $collection
 */
function scanRight_checkListStringWithNull(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, bool|string> $collection
 */
function scanRight_checkListOfSize1String(CollectionInterface $collection): void
{
}

scanRight_checkListInt(Collection::fromIterable([1, 2, 3])->scanRight($sum, 5));
scanRight_checkListString(Collection::fromIterable(range('a', 'c'))->scanRight($concat, ''));
scanRight_checkListStringWithNull(Collection::fromIterable(range('a', 'c'))->scanRight($concatWithNull));
scanRight_checkListOfSize1String(Collection::fromIterable([10])->scanRight($toString, true));
