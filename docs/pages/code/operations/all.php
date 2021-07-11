<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use ArrayIterator;
use Generator;
use loophp\collection\Collection;
use loophp\collection\Operation\All;
use loophp\collection\Operation\Filter;
use loophp\collection\Operation\Pipe;

include __DIR__ . '/../../../../vendor/autoload.php';

// Example 1 -> usage with Collection
$generator = static function (): Generator {
    yield 0 => 'a';

    yield 1 => 'b';

    yield 0 => 'c';

    yield 2 => 'd';
};

$collection = Collection::fromIterable($generator());
print_r($collection->all()); // [0 => 'c', 1 => 'b', 2 => 'd']

// Example 2 -> standalone usage
$even = static fn (int $value): bool => $value % 2 === 0;

$piped = Pipe::of()(Filter::of()($even), All::of())(new ArrayIterator([1, 2, 3, 4]));
print_r($piped); // [2, 4]
