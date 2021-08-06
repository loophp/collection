<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

$callback = static function ($value, $key): bool {
    var_dump('Value is: ' . $value . ', key is: ' . $key);

    return true;
};

$collection = Collection::fromIterable(['1', '2', '3']);

$collection
    ->apply($callback)
    ->squash(); // trigger the callback

/* Will print:
string(22) "Value is: 1, key is: 0"
string(22) "Value is: 2, key is: 1"
string(22) "Value is: 3, key is: 2"
 */
