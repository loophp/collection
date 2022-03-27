<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

$collection = Collection::fromIterable([1, 2, 3, 4, 5])
    ->averages(); // [1, 1.5, 2, 2.5, 3] from [1/1, (1+2)/2, (1+2+3)/3 ...]

$average = Collection::fromIterable([1, 2, 3, 4, 5])
    ->averages()
    ->last(); // [3]

$collection = Collection::empty()
    ->averages(); // []
