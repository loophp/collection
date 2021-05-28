<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;

/**
 * @param Collection<int, string> $collection
 */
function fromResource_check(Collection $collection): void
{
}

/** @var resource $resource */
$resource = fopen('https://loripsum.net/api', 'rb');
fromResource_check(Collection::fromResource($resource)->limit(25));
