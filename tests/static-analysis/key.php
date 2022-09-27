<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function key_checkInt(int $key): void
{
}

function key_checkNullableInt(?int $key): void
{
}
function key_checkString(string $key): void
{
}
function key_checkNullableString(?string $key): void
{
}

key_checkNullableInt(Collection::fromIterable([1, 2, 3])->key());
key_checkNullableInt(Collection::fromIterable([1, 2, 3])->key(2));
key_checkNullableString(Collection::fromIterable(['foo' => 'f', 'bar' => 'f'])->key());
key_checkNullableString(Collection::fromIterable(['foo' => 'f', 'bar' => 'f'])->key(1));

// VALID failure -> `key` can return `NULL` because `current` can return `NULL`
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
key_checkInt(Collection::fromIterable([1, 2, 3])->key());
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
key_checkInt(Collection::fromIterable([1, 2, 3])->key(2));

/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
key_checkString(Collection::fromIterable(['foo' => 'f', 'bar' => 'f'])->key());
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
key_checkString(Collection::fromIterable(['foo' => 'f', 'bar' => 'f'])->key(1));

// VALID failure -> mixed key
/** @psalm-suppress PossiblyInvalidArgument @phpstan-ignore-next-line */
key_checkInt(Collection::fromIterable([1, 2, 'foo' => 4])->key());
/** @psalm-suppress PossiblyInvalidArgument @phpstan-ignore-next-line */
key_checkString(Collection::fromIterable([1, 2, 'foo' => 4])->key());
