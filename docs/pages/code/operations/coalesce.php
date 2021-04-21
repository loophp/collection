<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

include __DIR__ . '/../vendor/autoload.php';

use loophp\collection\Collection;

$input = range('a', 'e');

$collection = Collection::fromIterable($input)
    ->coalesce(); // [ 0 => 'a' ]

$input = ['', null, 'foo', false, ...range('a', 'e')];

$collection = Collection::fromIterable($input)
    ->coalesce(); // [ 2 => 'foo' ]
