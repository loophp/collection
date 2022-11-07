<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

$concat = static fn (string $carry, string $string): string => sprintf('%s%s', $carry, $string);
$toString = static fn (int|string $carry, int $value): string => sprintf('%s', $value);

/**
 * @param CollectionInterface<int, string> $collection
 */
function scanLeft1_checkListString(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, string> $collection
 */
function scanLeft1_checkListOfSize1String(CollectionInterface $collection): void
{
}

// see Psalm bug: https://github.com/vimeo/psalm/issues/6108
scanLeft1_checkListString(Collection::fromIterable(range('a', 'c'))->scanLeft1($concat));
scanLeft1_checkListOfSize1String(Collection::fromIterable([10])->scanLeft1($toString));
