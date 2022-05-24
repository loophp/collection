<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;

// NGram: https://en.wikipedia.org/wiki/N-gram
$input = 'Hello world';

$ngrams = Collection::fromString($input)
    ->window(2)
    ->drop(2);

print_r($ngrams->all());
/*
[
    0 =>
        [
            0 => 'H',
            1 => 'e',
            2 => 'l',
        ],
    1 =>
        [
            0 => 'e',
            1 => 'l',
            2 => 'l',
        ],
    2 =>
        [
            0 => 'l',
            1 => 'l',
            2 => 'o',
        ],
    3 =>
        [
            0 => 'l',
            1 => 'o',
            2 => ' ',
        ],
    4 =>
        [
            0 => 'o',
            1 => ' ',
            2 => 'w',
        ],
    5 =>
        [
            0 => ' ',
            1 => 'w',
            2 => 'o',
        ],
    6 =>
        [
            0 => 'w',
            1 => 'o',
            2 => 'r',
        ],
    7 =>
        [
            0 => 'o',
            1 => 'r',
            2 => 'l',
        ],
    8 =>
        [
            0 => 'r',
            1 => 'l',
            2 => 'd',
        ],
];
 */
