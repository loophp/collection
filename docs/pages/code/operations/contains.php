<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

$result = Collection::fromIterable(range('a', 'c'))
    ->contains('d'); // false

$result = Collection::fromIterable(range('a', 'c'))
    ->contains('a', 'z'); // true

$result = Collection::fromIterable(['a' => 'b', 'c' => 'd'])
    ->contains('d'); // true
