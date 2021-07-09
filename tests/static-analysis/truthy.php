<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function truthy_check(bool $value): void
{
}

truthy_check(Collection::fromIterable([1, 2, 3])->truthy());
truthy_check(Collection::fromIterable([null, ''])->truthy());
truthy_check(Collection::fromIterable(['foo' => 'bar'])->truthy());

if (Collection::fromIterable([1, 2, 3])->truthy()) {
    // do something
}
