<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function mapN_checkListInt(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, string> $collection
 */
function mapN_checkListString(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function mapN_checkMapString(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, stdClass> $collection
 */
function mapN_checkMapClass(CollectionInterface $collection): void
{
}

$square = static fn (int $val): int => $val ** 2;
$toString = static fn (int $val): string => (string) $val;
$appendBar = static fn (string $val): string => $val . 'bar';
$toClass = static function (string $val): stdClass {
    $class = new stdClass();
    $class->val = $val;

    return $class;
};

mapN_checkListInt(Collection::fromIterable([1, 2, 3])->mapN($square));
mapN_checkListString(Collection::fromIterable([1, 2, 3])->mapN($square, $toString));

mapN_checkMapString(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->mapN($appendBar));
mapN_checkMapClass(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->mapN($appendBar, $toClass));

// Below are INVALID but are allowed by static analysis due to `mixed` usage in `mapN`.
// This is necessary in order to allow the flexibility that `mapN` requires with multiple callbacks.

mapN_checkListInt(Collection::fromIterable(['foo' => 'bar'])->mapN($square));
mapN_checkListString(Collection::fromIterable(['foo' => 'bar'])->mapN($square, $toString));

mapN_checkMapString(Collection::fromIterable([1, 2, 3])->mapN($appendBar));
mapN_checkMapClass(Collection::fromIterable([1, 2, 3])->mapN($appendBar, $toClass));
