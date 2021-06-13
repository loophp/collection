<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function current_checkNullable(?int $nullable): void
{
}
function current_checkNonNullable(int $nonNullable): void
{
}

current_checkNullable(Collection::fromIterable(range(0, 6))->current());
current_checkNullable(Collection::empty()->current());

// VALID failures because `current` can return `NULL` when the collection is empty

/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line  */
current_checkNonNullable(Collection::fromIterable(range(0, 6))->current());
/** @psalm-suppress NullArgument PHPStan is lost here, type inference for `empty` is not as good as Psalm */
current_checkNonNullable(Collection::empty()->current());
