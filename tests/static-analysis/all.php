<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

/**
 * @param array<int, int> $array
 */
function all_checkNumeric(array $array): void
{
}
/**
 * @param array<string, int> $array
 */
function all_checkMap(array $array): void
{
}
/**
 * @param array<int, string|int> $array
 */
function all_checkMixed(array $array): void
{
}

all_checkNumeric(Collection::empty()->all());
all_checkMap(Collection::empty()->all());
all_checkMixed(Collection::empty()->all());

all_checkNumeric(Collection::fromIterable([1, 2, 3])->all());
all_checkMap(Collection::fromIterable(['foo' => 1, 'bar' => 2])->all());
all_checkMixed(Collection::fromIterable([1, 2, 'b', '5', 4])->all());
