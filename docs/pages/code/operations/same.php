<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;
use stdClass;

include __DIR__ . '/../../../../vendor/autoload.php';

Collection::fromIterable([1, 2, 3])
    ->same(Collection::fromIterable([1, 2, 3])); // true

Collection::fromIterable([1, 2, 3])
    ->same(Collection::fromIterable([3, 1, 2])); // false

Collection::fromIterable([1, 2, 3])
    ->same(Collection::fromIterable([1, 2])); // false

Collection::fromIterable([1, 2, 3])
    ->same(Collection::fromIterable([1, 2, 4])); // false

Collection::fromIterable(['foo' => 'f'])
    ->same(Collection::fromIterable(['foo' => 'f'])); // true

Collection::fromIterable(['foo' => 'f'])
    ->same(Collection::fromIterable(['bar' => 'f'])); // false

Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])
    ->same(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])); // true

Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])
    ->same(Collection::fromIterable(['bar' => 'b', 'foo' => 'f'])); // false

$a = (object) ['id' => 'a'];
$a2 = (object) ['id' => 'a'];

Collection::fromIterable([$a])
    ->equals(Collection::fromIterable([$a])); // true

Collection::fromIterable([$a])
    ->equals(Collection::fromIterable([$a2])); // false

$comparator = static fn (string $left) => static fn (string $right): bool => $left === $right;
$this::fromIterable(['foo' => 'f'])
    ->same(Collection::fromIterable(['bar' => 'f']), $comparator); // true

$comparator = static fn ($left, $leftKey) => static fn ($right, $rightKey): bool => $left === $right
    && mb_strtolower($leftKey) === mb_strtolower($rightKey);
$this::fromIterable(['foo' => 'f'])
    ->same(Collection::fromIterable(['FOO' => 'f']), $comparator); // true

$comparator = static fn (stdClass $left) => static fn (stdClass $right): bool => $left->id === $right->id;
$this::fromIterable([$a])
    ->same(Collection::fromIterable([$a2]), $comparator); // true
