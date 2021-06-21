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
 * @param CollectionInterface<int, bool> $collection
 */
function every_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, bool> $collection
 */
function every_checkMap(CollectionInterface $collection): void
{
}
function every_checkBool(bool $value): void
{
}

$even = static fn (int $val): bool => $val % 2 === 0;
$negative = static fn (int $val): bool => 0 > $val;
$bar = static fn (string $val): bool => 'bar' === $val;
$long = static fn (string $val): bool => mb_strlen($val) > 3;

every_checkList(Collection::fromIterable([1, 2, 3])->every($even));
every_checkList(Collection::fromIterable([-1, 2, -3])->every($even, $negative));

every_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => 'taz'])->every($bar));
every_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => 'looooooooong'])->every($bar, $long));

// VALID failures below -> `current` can return `NULL` if the collection is empty

/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
every_checkBool(Collection::fromIterable([1, 2, 3])->every($even)->current());
/** @psalm-suppress InvalidArgument @phpstan-ignore-next-line */
every_checkBool(Collection::fromIterable(['foo' => 'bar', 'baz' => 'taz'])->every($bar)->current());

// explicit check is needed for PHPStan because the value is of type `bool|null`
if (true === Collection::fromIterable([1, 2, 3])->every($even)->current()) {
}
