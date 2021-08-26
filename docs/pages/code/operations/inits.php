<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

Collection::fromIterable(range('a', 'c'))
    ->inits(); // [[], [[0, 'a']], [[0, 'a'], [1, 'b']], [[0, 'a'], [1, 'b'], [2, 'c']]]
