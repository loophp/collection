<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function contains_check(bool $value): void
{
}

contains_check(Collection::fromIterable([1, 2, 3])->contains(2));
contains_check(Collection::fromIterable(range(1, 3))->contains(2, 4));

contains_check(Collection::fromIterable(['foo' => 'bar', 'baz' => 'taz'])->contains('bar'));
/** @psalm-suppress InvalidArgument -> Psalm is smart and knows that 'abc' cannot be in there */
contains_check(Collection::fromIterable(['foo' => 'bar', 'baz' => 'taz'])->contains('bar', 'abc'));

if (Collection::fromIterable([1, 2, 3])->contains(2)) {
    // do something
}
