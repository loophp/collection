<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

use const PHP_INT_MIN;

include __DIR__ . '/../../../../vendor/autoload.php';

$result = Collection::fromIterable([1, 4, 3, 0, 2])
    ->min(); // 0

$result = Collection::fromIterable([1, 4, null, 0, 2])
    ->min(); // null

$result = Collection::empty()
    ->min(PHP_INT_MIN); // PHP_INT_MIN
