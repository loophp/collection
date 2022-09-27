<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function count_check(int $count): void
{
}

count_check(Collection::fromIterable(range(0, 6))->count());
