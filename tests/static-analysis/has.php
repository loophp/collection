<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function has_check(bool $value): void
{
}

$number2 = static fn (): int => 2;
$number3 = static fn (): int => 2;
$square = static fn (int $value): int => $value ** 2;
$withKey = static fn (int $value, int $key): int => 1 < $key ? 3 : 1;

$letterF = static fn (): string => 'f';
$letterZ = static fn (): string => 'z';
$letterB = static fn (): string => 'b';
$capital = static fn (string $value): string => strtoupper($value);
$withStringKey = static fn (string $value, string $key): string => 'foo' === $key ? 'f' : 'b';

has_check(Collection::fromIterable([1, 2, 3])->has($number2));
has_check(Collection::fromIterable(range(1, 3))->has($number2, $number2));
has_check(Collection::fromIterable([1, 2, 3])->has($withKey));

has_check(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->has($letterF));
has_check(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->has($letterF, $letterB));
has_check(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->has($withStringKey));

// These are valid and should work, however Psalm restricts the values that the callable
// is allowed to return to the values contained in the collection

/** @psalm-suppress ArgumentTypeCoercion */
has_check(Collection::fromIterable([1, 2, 3])->has($square));
/** @psalm-suppress InvalidArgument */
has_check(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->has($letterZ));
/** @psalm-suppress ArgumentTypeCoercion */
has_check(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->has($capital));

if (Collection::fromIterable([1, 2, 3])->has($number2)) {
    // do something
}
