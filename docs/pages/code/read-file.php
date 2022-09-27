<?php

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;

$c = Collection::fromFile(__FILE__)
    ->lines()
    ->count();

print_r(sprintf('There are %s lines in this file.', $c)); // There are 13 lines in this file.
