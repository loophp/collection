<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function takeInt(int $int): void
{
}
function takeIntOrNull(?int $int): void
{
}
function takeString(string $string): void
{
}

takeInt(Collection::fromIterable([1, 2, 3])->first());
takeString(Collection::fromIterable(['foo' => 'bar', 'baz' => 'bar'])->first());
takeIntOrNull(Collection::empty()->first());
