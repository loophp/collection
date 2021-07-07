<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function isEmpty_check(bool $value): void
{
}

isEmpty_check(Collection::fromIterable([1, 2, 3])->isEmpty());
