<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function isEmpty_check(bool $value): void {}

isEmpty_check(Collection::fromIterable([1, 2, 3])->isEmpty());
