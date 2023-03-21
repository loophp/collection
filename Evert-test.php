<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/vendor/autoload.php';

$input = [
    'A' => ['a' => 'aa', 'b' => 'bb', 'c' => 'cc'],
    'B' => ['a' => 'aa', 'c' => 'cc'],
    'C' => ['b' => 'bb', 'c' => 'cc'],
];

$output = Collection::fromIterable($input)
    ->evert();

foreach ($output as $k => $v) {
    dump($k, $v);
}
