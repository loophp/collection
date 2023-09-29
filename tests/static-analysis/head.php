<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function head_checkList(?int $collection): void {}
function head_checkMap(?string $collection): void {}
function head_checkIntElement(int $value): void {}
function head_checkNullableInt(?int $value): void {}
function head_checkStringElement(string $value): void {}
function head_checkNullableString(?string $value): void {}

head_checkList(Collection::fromIterable([1, 2, 3])->head());
head_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->head());

head_checkList(Collection::empty()->head());
head_checkMap(Collection::empty()->head());

head_checkNullableInt(Collection::fromIterable([1, 2, 3])->head());
head_checkNullableString(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->head());

// This retrieval method doesn't cause static analysis complaints
// but is not always reliable because of that.
head_checkIntElement(Collection::fromIterable([1, 2, 3])->head(123));
head_checkStringElement(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->head('not-found'));
head_checkStringElement(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->head('not-found'));

// VALID failures - `current` returns T|null
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
head_checkIntElement(Collection::fromIterable([1, 2, 3])->head());
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
head_checkStringElement(Collection::fromIterable(['foo' => 'bar'])->head());

// VALID failures - these keys don't exist
/** @psalm-suppress InvalidArrayOffset */
head_checkIntElement(Collection::fromIterable([1, 2, 3])->head(123));
/** @psalm-suppress InvalidArrayOffset */
head_checkStringElement(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->head('default'));
