<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

function every_check(bool $value): void
{
}

$even = static fn (int $val): bool => $val % 2 === 0;
$negative = static fn (int $val): bool => 0 > $val;
$bar = static fn (string $val): bool => 'bar' === $val;
$long = static fn (string $val): bool => mb_strlen($val) > 3;

every_check(Collection::fromIterable([1, 2, 3])->every($even));
every_check(Collection::fromIterable([-1, 2, -3])->every($even, $negative));

every_check(Collection::fromIterable(['foo' => 'bar', 'baz' => 'taz'])->every($bar));
every_check(Collection::fromIterable(['foo' => 'bar', 'baz' => 'looooooooong'])->every($bar, $long));

if (Collection::fromIterable([1, 2, 3])->every($even)) {
    // do something
}
