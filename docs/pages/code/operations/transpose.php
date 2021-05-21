<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

// Example 1 -> classic matrix transpose
$collection = Collection::fromIterable([[1, 2, 3], [4, 5, 6], [7, 8, 9]])
    ->transpose();  // [1, 4, 7], [2, 5, 8], [3, 6, 9]

// Example 2 -> extract multiple keys
$records = [
    [
        'id' => 2135,
        'first_name' => 'John',
        'last_name' => 'Doe',
    ],
    [
        'id' => 3245,
        'first_name' => 'Sally',
        'last_name' => 'Smith',
    ],
    [
        'id' => 5342,
        'first_name' => 'Jane',
        'last_name' => 'Jones',
    ],
    [
        'id' => 5623,
        'first_name' => 'Peter',
        'last_name' => 'Doe',
    ],
];

$collection = Collection::fromIterable($records)
    ->transpose();

// [
//     'id' => [2135, 3245, 5432, 5623],
//     'first_name' => ['John', 'Sally', 'Jane', 'Peter'],
//     'last_name' => ['Doe', 'Smith', 'Jones', 'Doe']
// ]
