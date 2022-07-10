<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function takeInt(int $int): void
{
}

function takeIntOrNull(?int $int): void
{
}

function takeString(string $string): void
{
}

$sumNullable = static fn (?int $carry, int $value): int => null === $carry ? $value : $carry + $value;
$sum = static fn (int $carry, int $value): int => $carry + $value;

$concatNullable = static fn (?string $carry, string $string): string => null === $carry ? $string : $carry . $string;
$concat = static fn (string $carry, string $string): string => sprintf('%s%s', $carry, $string);

takeInt(Collection::fromIterable([1, 2, 3])->reduce($sumNullable));
takeIntOrNull(Collection::fromIterable([])->reduce($sumNullable));
takeInt(Collection::fromIterable([1, 2, 3])->reduce($sum, 0));

takeString(Collection::fromIterable(['z' => 'a', 'y' => 'b', 'x' => 'c'])->reduce($concatNullable));
takeString(Collection::fromIterable(['z' => 'a', 'y' => 'b', 'x' => 'c'])->reduce($concat, ''));
