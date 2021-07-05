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
function falsy_checkList(CollectionInterface $collection): void
{
}
function falsy_checkBool(bool $value): void
{
}

falsy_checkList(Collection::fromIterable([1, 2, 3])->falsy());
falsy_checkList(Collection::fromIterable([1, 2, 3])->falsy()->falsy());
falsy_checkList(Collection::fromIterable([null, ''])->falsy());
falsy_checkList(Collection::fromIterable(['foo' => 'bar'])->falsy());

// This retrieval method doesn't cause static analysis complaints
// but is not always reliable because of that.
falsy_checkBool(Collection::fromIterable([1, 2, 3])->falsy()->all()[0]);
falsy_checkBool(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->falsy()->all()[2]);

// VALID failures below -> `current` can return `NULL` if the collection is empty

/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
falsy_checkBool(Collection::fromIterable([1, 2, 3])->falsy()->current());
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
falsy_checkBool(Collection::fromIterable(['foo' => 'bar', 'baz' => 'taz'])->falsy()->current());

// explicit check is needed for PHPStan because the value is of type `bool|null`
if (true === Collection::fromIterable([1, 2, 3])->falsy()->current()) {
}
