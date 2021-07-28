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
function asyncMapN_checkListInt(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, non-empty-string> $collection
 */
function asyncMapN_checkListString(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, non-empty-string> $collection
 */
function asyncMapN_checkMapString(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, stdClass> $collection
 */
function asyncMapN_checkMapClass(CollectionInterface $collection): void
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

asyncMapN_checkListInt(Collection::fromIterable([1, 2, 3])->asyncMapN($square));
asyncMapN_checkListString(Collection::fromIterable([1, 2, 3])->asyncMapN($square, $toString));

asyncMapN_checkMapString(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->asyncMapN($appendBar));
asyncMapN_checkMapClass(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->asyncMapN($appendBar, $toClass));

// Below are INVALID but are allowed by static analysis due to `mixed` usage in `asyncMapN`.
// This is necessary in order to allow the flexibility that `asyncMapN` requires with multiple callbacks.

asyncMapN_checkListInt(Collection::fromIterable(['foo' => 'bar'])->asyncMapN($square));
asyncMapN_checkListString(Collection::fromIterable(['foo' => 'bar'])->asyncMapN($square, $toString));

asyncMapN_checkMapString(Collection::fromIterable([1, 2, 3])->asyncMapN($appendBar));
asyncMapN_checkMapClass(Collection::fromIterable([1, 2, 3])->asyncMapN($appendBar, $toClass));
