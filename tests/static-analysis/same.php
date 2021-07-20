<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function same_check(bool $value): void
{
}

$a = (object) ['id' => 'a'];
$a2 = (object) ['id' => 'a'];
$b = (object) ['id' => 'b'];

same_check(Collection::fromIterable([1, 2, 3])->same(Collection::fromIterable([3, 2, 1])));
same_check(Collection::fromIterable([1, 2, 3])->same(Collection::empty()));
same_check(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->same(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])));
same_check(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->same(Collection::fromIterable(['foo' => 'f'])));
same_check(Collection::fromIterable([$a])->same(Collection::fromIterable([$b])));
same_check(Collection::fromIterable([$a])->same(Collection::fromIterable([$a])));
same_check(Collection::fromIterable([$a])->same(Collection::fromIterable([$a2])));
same_check(Collection::fromIterable([$a, $b])->same(Collection::fromIterable([$a2, $b])));
same_check(Collection::fromIterable([$a, $b])->same(Collection::fromIterable([$b, $a])));

$comparator = static fn (string $left): Closure => static fn (string $right): bool => $left === $right;
same_check(Collection::fromIterable(['foo' => 'f'])->same(Collection::fromIterable(['foo' => 'f']), $comparator));

$comparator = static fn (string $left, string $leftKey): Closure => static fn (string $right, string $rightKey): bool => $left === $right
    && mb_strtolower($leftKey) === mb_strtolower($rightKey);
same_check(Collection::fromIterable(['foo' => 'f'])->same(Collection::fromIterable(['foo' => 'f']), $comparator));

$comparator = static fn (stdClass $left): Closure => static fn (stdClass $right): bool => $left->id === $right->id;
same_check(Collection::fromIterable([$a])->same(Collection::fromIterable([$a2]), $comparator));

// VALID failures -> usage with different types
// Note some of these might be allowed due to the option of having a custom comparator
// We'll need to see if this causes issues - we might want to allow comparing collections with different template types

/** @psalm-suppress InvalidArgument -> Psalm narrows the types to 1|2|3 and 4|5 and knows these cannot work */
same_check(Collection::fromIterable([1, 2, 3])->same(Collection::fromIterable([4, 5])));
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
same_check(Collection::fromIterable([1, 2, 3])->same(Collection::fromIterable(['a', 'b'])));
/** @psalm-suppress InvalidArgument -> Psalm sees the keys and values are completely different */
same_check(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->same(Collection::fromIterable(['other' => 'x'])));
/** @psalm-suppress InvalidArgument -> Psalm sees that one collection has fewer values for keys */
same_check(Collection::fromIterable([$a])->same(Collection::fromIterable([$a, $b])));

$comparator = static fn (string $left): Closure => static fn (string $right): bool => $left === $right;
/** @psalm-suppress InvalidArgument -> Psalm narrows the types and sees that the keys are different */
same_check(Collection::fromIterable(['foo' => 'f'])->same(Collection::fromIterable(['bar' => 'f']), $comparator));

$comparator = static fn (string $left, string $leftKey): Closure => static fn (string $right, string $rightKey): bool => $left === $right
    && mb_strtolower($leftKey) === mb_strtolower($rightKey);
/** @psalm-suppress InvalidArgument -> Psalm sees that the keys are different */
same_check(Collection::fromIterable(['foo' => 'f'])->same(Collection::fromIterable(['FOO' => 'f']), $comparator));
