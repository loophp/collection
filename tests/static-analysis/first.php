<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function first_takeInt(?int $int): void
{
}
function first_takeIntOrNull(?int $int): void
{
}
function first_takeString(?string $string): void
{
}

first_takeInt(Collection::fromIterable([1, 2, 3])->first());
first_takeString(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->first());
first_takeIntOrNull(Collection::empty()->first());
