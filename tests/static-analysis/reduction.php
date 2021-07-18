<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

$sum = static fn (int $carry, int $value): int => $carry + $value;
$concat = static fn (?string $carry, string $string): string => sprintf('%s%s', (string) $carry, $string);

/**
 * @param CollectionInterface<int, int> $collection
 */
function reduction_checkListInt(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, string> $collection
 */
function reduction_checkListString(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, string|null> $collection
 */
function reduction_checkListStringWithNull(CollectionInterface $collection): void
{
}

reduction_checkListInt(Collection::fromIterable([1, 2, 3])->reduction($sum, 5));
reduction_checkListString(Collection::fromIterable(range('a', 'c'))->reduction($concat, ''));
reduction_checkListStringWithNull(Collection::fromIterable(range('a', 'c'))->reduction($concat));
