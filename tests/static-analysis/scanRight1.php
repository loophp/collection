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
function scanRight1_checkListString(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, int|string> $collection
 */
function scanRight1_checkListOfSize1String(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<string|int, string|int> $collection
 */
function scanRight1_checkMixedInput(CollectionInterface $collection): void
{
}

$intGenerator =
    /**
     * @return Generator<int, int>
     */
    static function (): Generator {
        while (true) {
            $int = random_int(0, \PHP_INT_MAX);

            yield $int => $int;
        }
    };

// see Psalm bug: https://github.com/vimeo/psalm/issues/6108
scanRight1_checkListString(Collection::fromIterable(range('a', 'c'))->scanRight1($concat));
scanRight1_checkListOfSize1String(Collection::fromIterable($intGenerator())->scanRight1($toString));
scanRight1_checkMixedInput(Collection::fromIterable(array_combine(range('a', 'e'), range('a', 'e')))->scanRight1(static fn (int|string $carry, string $value): int => ord($value)));
