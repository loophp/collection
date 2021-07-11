<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

$sum = static fn (?int $carry, int $value): int => (int) $carry + $value;
$concat = static fn (?string $carry, string $string): string => sprintf('%s%s', (string) $carry, $string);

/**
 * @param CollectionInterface<int, int|null> $collection
 */
function reduce_checkListInt(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, string|null> $collection
 */
function reduce_checkListString(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<string, string> $collection
 */
function reduce_checkMapString(CollectionInterface $collection): void
{
}

reduce_checkListInt(Collection::fromIterable([1, 2, 3])->reduce($sum));
reduce_checkListString(Collection::fromIterable(range('a', 'e'))->reduce($concat));

reduce_checkMapString(Collection::fromIterable(['z' => 'a', 'y' => 'b', 'x' => 'c'])->reduce($concat, ''));
