<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function foldleft_takeInt(int $int): void {}

function foldleft_takeIntOrNull(?int $int): void {}

function foldleft_takeString(string $string): void {}

function foldleft_takeStringOrNull(?string $string): void {}

function foldleft_takeIntOrBool(bool|int $v): void {}

$sumNullable = static fn (?int $carry, int $value): int => null === $carry ? $value : $carry + $value;
$sum = static fn (int $carry, int $value): int => $carry + $value;

$concatNullable = static fn (?string $carry, string $string): string => null === $carry ? $string : $carry . $string;
$concat = static fn (string $carry, string $string): string => sprintf('%s%s', $carry, $string);

foldleft_takeIntOrNull(Collection::fromIterable([1, 2, 3])->foldLeft($sumNullable, null));
foldleft_takeIntOrNull(Collection::fromIterable([])->foldLeft($sumNullable, null));
foldleft_takeInt(Collection::fromIterable([1, 2, 3])->foldLeft($sum, 0));

foldleft_takeStringOrNull(Collection::fromIterable(['z' => 'a', 'y' => 'b', 'x' => 'c'])->foldLeft($concatNullable, null));
foldleft_takeString(Collection::fromIterable(['z' => 'a', 'y' => 'b', 'x' => 'c'])->foldLeft($concat, ''));

foldleft_takeIntOrBool(Collection::fromIterable([1, 2, 3])->foldLeft(static fn (bool|int $c, $v): int => $v, true));
