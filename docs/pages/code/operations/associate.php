<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

// Example 1: Both callbacks are provided
$input = range(1, 5);

Collection::fromIterable($input)
    ->associate(
        static function ($key, $value) {
            return $key * 2;
        },
        static function ($value, $key) {
            return $value * 3;
        }
    );

// [
//   0 => 3,
//   2 => 6,
//   4 => 9,
//   6 => 12,
//   8 => 15,
// ]

// Example 2: Only the callback for keys is provided
$input = range(1, 5);

Collection::fromIterable($input)
    ->associate(
        static function ($key, $value) {
            return $key * 2;
        }
    );

// [
//   0 => 1,
//   2 => 2,
//   4 => 3,
//   6 => 4,
//   8 => 5,
// ]

// Example 3: Only the callback for values is provided
$input = range(1, 5);

Collection::fromIterable($input)
    ->associate(
        null,
        static function ($value, $key) {
            return $value * 3;
        }
    );

// [
//   0 => 3,
//   1 => 6,
//   2 => 9,
//   3 => 12,
//   4 => 15,
// ]
