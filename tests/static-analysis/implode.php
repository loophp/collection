<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function implode_takeString(string $string): void
{
}

// TODO: Replace with loophp/typed-generators when it will be done.
$input = range('a', 'e');

implode_takeString(Collection::fromIterable($input)->implode(','));
implode_takeString(Collection::fromIterable([])->implode());
