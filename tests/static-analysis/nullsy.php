<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function nullsy_check(bool $value): void
{
}

nullsy_check(Collection::fromIterable([1, 2, 3])->nullsy());
nullsy_check(Collection::fromIterable([null, ''])->nullsy());
nullsy_check(Collection::fromIterable(['foo' => 'bar'])->nullsy());

if (Collection::fromIterable([1, 2, 3])->nullsy()) {
    // do something
}
