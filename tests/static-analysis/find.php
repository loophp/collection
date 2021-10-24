<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function find_checkIntElement(int $value): void
{
}
function find_checkNullableInt(?int $value): void
{
}
function find_checkStringElement(string $value): void
{
}
function find_checkNullableString(?string $value): void
{
}

$intValueCallback = static fn (int $value): bool => $value % 2 === 0;
$intValueCallback2 = static fn (int $value): bool => 2 < $value;
$intKeyValueCallback1 = static fn (int $value, int $key): bool => $value % 2 === 0 && $key % 2 === 0;
$intKeyValueCallback2 = static fn (int $value, int $key): bool => 2 < $value && 2 < $key;

$stringValueCallback = static fn (string $value): bool => 'bar' === $value;
$stringValueCallback2 = static fn (string $value): bool => '' === $value;
$stringKeyValueCallback1 = static fn (string $value, string $key): bool => 'bar' !== $value && 'foo' !== $key;
$stringKeyValueCallback2 = static fn (string $value, string $key): bool => 'bar' !== $value && '' === $key;

find_checkNullableInt(Collection::fromIterable([1, 2, 3])->find(null, $intValueCallback));
find_checkNullableInt(Collection::fromIterable([1, 2, 3])->find(null, $intValueCallback, $intValueCallback2));
find_checkNullableInt(Collection::fromIterable([1, 2, 3])->find(null, $intKeyValueCallback1));
find_checkNullableInt(Collection::fromIterable([1, 2, 3])->find(null, $intKeyValueCallback1, $intKeyValueCallback2));

find_checkNullableString(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->find(null, $stringValueCallback));
find_checkNullableString(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->find(null, $stringValueCallback, $stringValueCallback2));
find_checkNullableString(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->find(null, $stringKeyValueCallback1));
find_checkNullableString(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->find(null, $stringKeyValueCallback1, $stringKeyValueCallback2));

find_checkIntElement(Collection::fromIterable([1, 2, 3])->find(-1, $intValueCallback));
find_checkStringElement(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->find('not found', $stringValueCallback));

// VALID failures - `null` as default value
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
find_checkIntElement(Collection::fromIterable([1, 2, 3])->find(null, $intValueCallback));
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
find_checkStringElement(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->find(null, $stringValueCallback));

// VALID failures - default value type mismatch
/** @psalm-suppress PossiblyInvalidArgument @phpstan-ignore-next-line */
find_checkIntElement(Collection::fromIterable([1, 2, 3])->find('not integer', $intValueCallback));
/** @psalm-suppress PossiblyInvalidArgument @phpstan-ignore-next-line */
find_checkStringElement(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->find(-1, $stringValueCallback));

/*
PHP 8 - using named parameters and the default `null` value -> these should legitimately fail,
but Psalm reports no issue and PHPStan is reporting a different error than expected:
"Parameter #1 $value of function find_checkNullableInt expects int|null, (Closure)|int given."

find_checkNullableInt(Collection::fromIterable([1, 2, 3])->find(callbacks: $intValueCallback));
find_checkNullableString(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->find(callbacks: $stringValueCallback));
 */

/*
PHP 8 - using named parameters and the default `null` value -> these should legitimately fail,
but Psalm reports no issue and the current PHPStan failures are due to the error mentioned above.

find_checkIntElement(Collection::fromIterable([1, 2, 3])->find(callbacks: $intValueCallback));
find_checkStringElement(Collection::fromIterable(['foo' => 'a', 'bar' => 'b'])->find(callbacks: $stringValueCallback));
 */
