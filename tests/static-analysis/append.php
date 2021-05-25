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
function append_checkNumeric(Collection $collection): void
{
}
/**
 * @param Collection<int, array<string, int>> $collection
 */
function append_checkListWithMap(Collection $collection): void
{
}

append_checkNumeric(Collection::empty()->append(1));
append_checkNumeric(Collection::empty()->append(1, 2));
append_checkNumeric(Collection::empty()->append(...[1, 2]));
append_checkNumeric(Collection::fromIterable([5])->append(1));
append_checkNumeric(Collection::fromIterable([5])->append(1, 2));
append_checkNumeric(Collection::fromIterable([5])->append(...[1, 2]));

/** @var array<string, int> $foo */
$foo = ['foo' => 1];
/** @var array<string, int> $bar */
$bar = ['bar' => 2];
/** @var array<string, int> $baz */
$baz = ['baz' => 3];

append_checkListWithMap(Collection::empty()->append($foo));
append_checkListWithMap(Collection::empty()->append($foo, $bar));
append_checkListWithMap(Collection::empty()->append(...[$foo, $bar]));
append_checkListWithMap(Collection::fromIterable([1 => $foo])->append($bar));
append_checkListWithMap(Collection::fromIterable([1 => $foo])->append($bar, $baz));
append_checkListWithMap(Collection::fromIterable([1 => $foo])->append(...[$bar, $baz]));
