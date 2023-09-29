<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function current_checkNullable(?int $nullable): void {}
function current_checkNonNullable(int $nonNullable): void {}
function current_checkNonNullableWithDefaultValue(bool|int $default): void {}
function current_checkEmptyWithDefaultValue(string $default): void {}

function randomString(): string
{
    $alphabet = range('a', 'z');

    return $alphabet[array_rand($alphabet)];
}

current_checkNullable(Collection::fromIterable(range(0, 6))->current());
current_checkNullable(Collection::empty()->current());

current_checkNonNullableWithDefaultValue(Collection::fromIterable(range(0, 6))->current(10, false));
current_checkEmptyWithDefaultValue(Collection::empty()->current(10, randomString()));

current_checkNonNullable(Collection::fromIterable(range(0, 6))->current(0, -1));

// VALID failures because `current` can return `NULL` when the collection is empty
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line  */
current_checkNonNullable(Collection::fromIterable(range(0, 6))->current());
/** @psalm-suppress NullArgument PHPStan is lost here, type inference for `empty` is not as good as Psalm */
current_checkNonNullable(Collection::empty()->current());

// VALID failures because `current` can use a default value of any type
/** @psalm-suppress PossiblyInvalidArgument @phpstan-ignore-next-line */
current_checkNonNullable(Collection::fromIterable(range(0, 6))->current(0, 'not found'));
/** @psalm-suppress InvalidArgument */
current_checkEmptyWithDefaultValue(Collection::empty()->current(10, 404));
