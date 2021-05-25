<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\collection;

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

/**
 * @param Collection<int, int> $collection
 */
function checkNumeric(Collection $collection): void
{
}
/**
 * @param Collection<int, array<string, int>> $collection
 */
function checkListWithMap(Collection $collection): void
{
}

checkNumeric(Collection::empty()->append(1));
checkNumeric(Collection::empty()->append(1, 2));
checkNumeric(Collection::empty()->append(...[1, 2]));
checkNumeric(Collection::fromIterable([5])->append(1));
checkNumeric(Collection::fromIterable([5])->append(1, 2));
checkNumeric(Collection::fromIterable([5])->append(...[1, 2]));

/** @var array<string, int> $foo */
$foo = ['foo' => 1];
/** @var array<string, int> $bar */
$bar = ['bar' => 2];
/** @var array<string, int> $baz */
$baz = ['baz' => 3];

checkListWithMap(Collection::empty()->append($foo));
checkListWithMap(Collection::empty()->append($foo, $bar));
checkListWithMap(Collection::empty()->append(...[$foo, $bar]));
checkListWithMap(Collection::fromIterable([1 => $foo])->append($bar));
