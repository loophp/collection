<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function reduce_takeInt(int $int): void
{
}

function reduce_takeIntOrNull(?int $int): void
{
}

function reduce_takeString(string $string): void
{
}

function reduce_takeStringOrNull(?string $string): void
{
}

function reduce_takeIntOrBool(int|bool $v): void
{
}

$sumNullable = static fn (?int $carry, int $value): int => null === $carry ? $value : $carry + $value;
$sum = static fn (int $carry, int $value): int => $carry + $value;

$concatNullable = static fn (?string $carry, string $string): string => null === $carry ? $string : $carry . $string;
$concat = static fn (string $carry, string $string): string => sprintf('%s%s', $carry, $string);

reduce_takeIntOrNull(Collection::fromIterable([1, 2, 3])->reduce($sumNullable));
reduce_takeIntOrNull(Collection::fromIterable([])->reduce($sumNullable));
reduce_takeInt(Collection::fromIterable([1, 2, 3])->reduce($sum, 0));

reduce_takeStringOrNull(Collection::fromIterable(['z' => 'a', 'y' => 'b', 'x' => 'c'])->reduce($concatNullable));
reduce_takeString(Collection::fromIterable(['z' => 'a', 'y' => 'b', 'x' => 'c'])->reduce($concat, ''));

reduce_takeIntOrBool(Collection::fromIterable([1, 2, 3])->reduce(static fn (bool|int $c, $v): int => $v, true));
