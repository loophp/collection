<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Operation\All;
use loophp\collection\Operation\Filter;
use loophp\collection\Operation\Pipe;

/**
 * @param array<int, int> $array
 */
function all_checkList(array $array): void
{
}
/**
 * @param array<string, int> $array
 */
function all_checkMap(array $array): void
{
}
/**
 * @param array<int, int|string> $array
 */
function all_checkMixed(array $array): void
{
}

$input = [1, 2, 3, 4];
$even = static fn (int $value): bool => $value % 2 === 0;

// Standalone usage
$piped = Pipe::of()(Filter::of()($even), All::of())((new ArrayIterator($input)));

print_r($piped);

all_checkList(Collection::empty()->all());
all_checkMap(Collection::empty()->all());
all_checkMixed(Collection::empty()->all());

all_checkList(Collection::fromIterable([1, 2, 3])->all());
all_checkMap(Collection::fromIterable(['foo' => 1, 'bar' => 2])->all());
all_checkMixed(Collection::fromIterable([1, 2, 'b', '5', 4])->all());
