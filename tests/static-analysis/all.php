<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

/**
 * @param array<int, int> $array
 */
function all_checkList(array $array): void
{
}
/**
 * @param array<string, int> $array
 */
function all_checkMap(array $array): void
{
}
/**
 * @param array<int, int|string> $array
 */
function all_checkMixed(array $array): void
{
}

all_checkList(Collection::fromIterable([1, 2, 3])->all());
all_checkList(Collection::fromIterable([1, 2, 3])->all(false));
all_checkMixed(Collection::fromIterable([1, 2, 'b', '5', 4])->all());
all_checkMixed(Collection::fromIterable([1, 2, 'b', '5', 4])->all(false));

// VALID failures -> improper usage
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
all_checkMap(Collection::fromIterable(['foo' => 1, 'bar' => 2])->all());
/** @psalm-suppress InvalidScalarArgument @phpstan-ignore-next-line */
all_checkList(Collection::fromIterable(['foo' => 1, 'bar' => 2])->all(false));

all_checkMap(Collection::fromIterable(['foo' => 1, 'bar' => 2])->all(false));
all_checkList(Collection::empty()->all());
/** @phpstan-ignore-next-line */
all_checkMap(Collection::empty()->all(false));
all_checkMixed(Collection::empty()->all());
