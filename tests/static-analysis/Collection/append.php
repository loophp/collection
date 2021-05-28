<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;

/**
 * @param Collection<int, int> $collection
 */
function append_checkList(Collection $collection): void
{
}
/**
 * @param Collection<int, array<string, int>> $collection
 */
function append_checkListWithMap(Collection $collection): void
{
}
/**
 * @param Collection<int|string, int|string> $collection
 */
function append_checkMixed(Collection $collection): void
{
}

// Annotations are needed because Collection allows appending items of any type,
// therefore the method cannot provide a strict guarantee
// for the types of the return Collection

/** @var Collection<int, int> $list */
$list = Collection::empty()->append(1);
append_checkList($list);

/** @var Collection<int, int> $list */
$list = Collection::empty()->append(1, 2);
append_checkList($list);

/** @var Collection<int, int> $list */
$list = Collection::empty()->append(...[1, 2]);
append_checkList($list);

/** @var Collection<int, int> $list */
$list = Collection::fromIterable([5])->append(2);
append_checkList($list);

/** @var Collection<int, int> $list */
$list = Collection::fromIterable([5])->append(1, 2);
append_checkList($list);

/** @var Collection<int, int> $list */
$list = Collection::fromIterable([5])->append(...[1, 2]);
append_checkList($list);

/** @var Collection<int, array<string, int>> $list */
$list = Collection::empty()->append(['foo' => 1]);
append_checkListWithMap($list);

/** @var Collection<int, array<string, int>> $list */
$list = Collection::empty()->append(['foo' => 1], ['bar' => 2]);
append_checkListWithMap($list);

/** @var Collection<int, array<string, int>> $list */
$list = Collection::empty()->append(...[['foo' => 1], ['bar' => 2]]);
append_checkListWithMap($list);

/** @var Collection<int, array<string, int>> $list */
$list = Collection::fromIterable([1 => ['foo' => 1]])->append(['bar' => 2]);
append_checkListWithMap($list);

/** @var Collection<int|string, int|string> $mixed */
$mixed = Collection::empty()->append(1, '2');
append_checkMixed($mixed);

/** @var Collection<int|string, int|string> $mixed */
$mixed = Collection::empty()->append(...[1, '2']);
append_checkMixed($mixed);

/** @var Collection<int|string, int|string> $mixed */
$mixed = Collection::fromIterable(['foo' => 1])->append(1, '2');
append_checkMixed($mixed);
