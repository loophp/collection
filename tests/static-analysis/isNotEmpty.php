<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function isNotEmpty_check(bool $value): void {}

function isNotEmpty_checkMap(bool $value): void {}

isNotEmpty_check(Collection::fromIterable([])->isNotEmpty());
isNotEmpty_check(Collection::fromIterable([1, 2, 3])->isNotEmpty());
isNotEmpty_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->isNotEmpty());
