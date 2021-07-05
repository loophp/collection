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
function truthy_checkList(CollectionInterface $collection): void
{
}
function truthy_checkBool(bool $value): void
{
}

truthy_checkList(Collection::fromIterable([1, 2, 3])->truthy());
truthy_checkList(Collection::fromIterable([1, 2, 3])->truthy()->truthy());
truthy_checkList(Collection::fromIterable([null, ''])->truthy());
truthy_checkList(Collection::fromIterable(['foo' => 'bar'])->truthy());

// This retrieval method doesn't cause static analysis complaints
// but is not always reliable because of that.
truthy_checkBool(Collection::fromIterable([1, 2, 3])->truthy()->all()[0]);
truthy_checkBool(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->truthy()->all()[2]);

// VALID failures below -> `current` can return `NULL` if the collection is empty

/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
truthy_checkBool(Collection::fromIterable([1, 2, 3])->truthy()->current());
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
truthy_checkBool(Collection::fromIterable(['foo' => 'bar', 'baz' => 'taz'])->truthy()->current());

// explicit check is needed for PHPStan because the value is of type `bool|null`
if (true === Collection::fromIterable([1, 2, 3])->truthy()->current()) {
}
