<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

Collection::fromIterable([1, 2, 3])
    ->equals(Collection::fromIterable([1, 2, 3])); // true

Collection::fromIterable([1, 2, 3])
    ->equals(Collection::fromIterable([3, 1, 2])); // true

Collection::fromIterable([1, 2, 3])
    ->equals(Collection::fromIterable([1, 2])); // false

Collection::fromIterable([1, 2, 3])
    ->equals(Collection::fromIterable([1, 2, 4])); // false

Collection::fromIterable(['foo' => 'f'])
    ->equals(Collection::fromIterable(['foo' => 'f'])); // true

Collection::fromIterable(['foo' => 'f'])
    ->same(Collection::fromIterable(['bar' => 'f'])); // true

Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])
    ->equals(Collection::fromIterable(['foo' => 'f', 'baz' => 'b'])); // true

$a = (object) ['id' => 'a'];
$a2 = (object) ['id' => 'a'];

Collection::fromIterable([$a])
    ->equals(Collection::fromIterable([$a])); // true

Collection::fromIterable([$a])
    ->equals(Collection::fromIterable([$a2])); // false
