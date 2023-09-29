<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function equals_check(bool $value): void {}

$a = (object) ['id' => 'a'];
$a2 = (object) ['id' => 'a'];
$b = (object) ['id' => 'b'];

equals_check(Collection::fromIterable([1, 2, 3])->equals(Collection::fromIterable([3, 2, 1])));
equals_check(Collection::fromIterable([1, 2, 3])->equals(Collection::empty()));
equals_check(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->equals(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])));
equals_check(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->equals(Collection::fromIterable(['foo' => 'f'])));
equals_check(Collection::fromIterable([$a])->equals(Collection::fromIterable([$b])));
equals_check(Collection::fromIterable([$a])->equals(Collection::fromIterable([$a])));
equals_check(Collection::fromIterable([$a])->equals(Collection::fromIterable([$a2])));
equals_check(Collection::fromIterable([$a, $b])->equals(Collection::fromIterable([$a2, $b])));
equals_check(Collection::fromIterable([$a, $b])->equals(Collection::fromIterable([$b, $a])));

// VALID failures -> usage with different types

/** @psalm-suppress InvalidArgument -> Psalm narrows the types to 1|2|3 and 4|5 and knows these cannot work */
equals_check(Collection::fromIterable([1, 2, 3])->equals(Collection::fromIterable([4, 5])));
/** @psalm-suppress InvalidArgument */
equals_check(Collection::fromIterable([1, 2, 3])->equals(Collection::fromIterable(['a', 'b'])));
/** @psalm-suppress InvalidArgument -> Psalm sees the keys and values are completely different */
equals_check(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->equals(Collection::fromIterable(['other' => 'x'])));
/** @psalm-suppress InvalidArgument -> Psalm sees that one collection has fewer values for keys */
equals_check(Collection::fromIterable([$a])->equals(Collection::fromIterable([$a, $b])));
