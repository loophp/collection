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
function nullsy_checkList(CollectionInterface $collection): void
{
}
function nullsy_checkBool(bool $value): void
{
}

nullsy_checkList(Collection::fromIterable([1, 2, 3])->nullsy());
nullsy_checkList(Collection::fromIterable([1, 2, 3])->nullsy()->nullsy());
nullsy_checkList(Collection::fromIterable([null, ''])->nullsy());
nullsy_checkList(Collection::fromIterable(['foo' => 'bar'])->nullsy());

// This retrieval method doesn't cause static analysis complaints
// but is not always reliable because of that.
nullsy_checkBool(Collection::fromIterable([1, 2, 3])->nullsy()->all()[0]);
nullsy_checkBool(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->nullsy()->all()[2]);

// VALID failures below -> `current` can return `NULL` if the collection is empty

/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
nullsy_checkBool(Collection::fromIterable([1, 2, 3])->nullsy()->current());
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
nullsy_checkBool(Collection::fromIterable(['foo' => 'bar', 'baz' => 'taz'])->nullsy()->current());

// explicit check is needed for PHPStan because the value is of type `bool|null`
if (true === Collection::fromIterable([1, 2, 3])->nullsy()->current()) {
}
