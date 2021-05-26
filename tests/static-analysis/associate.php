<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

/**
 * @param Collection<int, int> $collection
 */
function associate_checkNumeric(Collection $collection): void
{
}
/**
 * @param Collection<non-empty-string, int> $collection
 */
function associate_checkMap(Collection $collection): void
{
}
/**
 * @param Collection<int, int|string> $collection
 */
function associate_checkMixed(Collection $collection): void
{
}

associate_checkNumeric(Collection::empty()->associate());
associate_checkMap(Collection::empty()->associate());
associate_checkMixed(Collection::empty()->associate());

associate_checkNumeric(Collection::fromIterable([1, 2, 3])->associate());
associate_checkMap(Collection::fromIterable(['foo' => 1, 'bar' => 2])->associate());
associate_checkMixed(Collection::fromIterable([1, 2, 'b', '5', 4])->associate());

associate_checkNumeric(Collection::fromIterable([4, 5, 6])->associate(static fn (int $carry, int $key): int => $key * 2));
associate_checkNumeric(Collection::fromIterable([4, 5, 6])->associate(static fn (int $carry, int $key, int $value) => $key * 2));
associate_checkNumeric(
    Collection::fromIterable([4, 5, 6])->associate(
        null,
        static fn (int $carry, int $key, int $value) => $value
    )
);
associate_checkNumeric(Collection::fromIterable([4, 5, 6])->associate(
    static fn (int $carry, int $key): int => $key * 2,
    static fn (int $carry, int $key, int $value): int => $value * -1
));

associate_checkMap(Collection::fromIterable(['foo' => 1, 'bar' => 2])->associate(static fn (string $carry, string $key): string => "{$key}z"));
