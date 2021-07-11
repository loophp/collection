<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function falsy_check(bool $value): void
{
}

falsy_check(Collection::fromIterable([1, 2, 3])->falsy());
falsy_check(Collection::fromIterable([null, ''])->falsy());
falsy_check(Collection::fromIterable(['foo' => 'bar'])->falsy());

if (!Collection::fromIterable([1, 2, 3])->falsy()) {
    // do something
}
