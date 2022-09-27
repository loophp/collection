<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function last_checkList(?int $last): void
{
}
function last_checkMap(?string $last): void
{
}
function last_checkIntElement(int $value): void
{
}
function last_checkNullableInt(?int $value): void
{
}
function last_checkStringElement(string $value): void
{
}
function last_checkNullableString(?string $value): void
{
}

last_checkList(Collection::fromIterable([1, 2, 3])->last());
last_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->last());

last_checkList(Collection::empty()->last());
last_checkMap(Collection::empty()->last());

last_checkNullableInt(Collection::fromIterable([1, 2, 3])->last());
last_checkNullableString(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->last());

// This retrieval method doesn't cause static analysis complaints
// but is not always reliable because of that.
last_checkIntElement(Collection::fromIterable([1, 2, 3])->last(0));
last_checkStringElement(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->last(''));

// VALID failures - `current` returns T|null
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
last_checkIntElement(Collection::fromIterable([1, 2, 3])->last());
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
last_checkStringElement(Collection::fromIterable(['foo' => 'bar'])->last());
