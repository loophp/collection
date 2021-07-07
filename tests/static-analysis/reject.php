<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function reject_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function reject_checkMap(CollectionInterface $collection): void
{
}

$intValueCallback = static fn (int $value): bool => $value % 2 === 0;
$intValueCallback2 = static fn (int $value): bool => 2 < $value;
$intKeyValueCallback1 = static fn (int $value, int $key): bool => $value % 2 === 0 && $key % 2 === 0;
$intKeyValueCallback2 = static fn (int $value, int $key): bool => 2 < $value && 2 < $key;

$stringValueCallback = static fn (string $value): bool => 'bar' === $value;
$stringValueCallback2 = static fn (string $value): bool => '' === $value;
$stringKeyValueCallback1 = static fn (string $value, string $key): bool => 'bar' !== $value && 'foo' !== $key;
$stringKeyValueCallback2 = static fn (string $value, string $key): bool => 'bar' !== $value && '' === $key;

reject_checkList(Collection::fromIterable([1, 2, 3])->reject());
reject_checkList(Collection::fromIterable([1, 2, 3])->reject($intValueCallback));
reject_checkList(Collection::fromIterable([1, 2, 3])->reject($intValueCallback, $intValueCallback2));
reject_checkList(Collection::fromIterable([1, 2, 3])->reject($intKeyValueCallback1));
reject_checkList(Collection::fromIterable([1, 2, 3])->reject($intKeyValueCallback1, $intKeyValueCallback2));

reject_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => ''])->reject());
reject_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => ''])->reject($stringValueCallback));
reject_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => ''])->reject($stringValueCallback, $stringValueCallback2));
reject_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => ''])->reject($stringKeyValueCallback1));
reject_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => ''])->reject($stringKeyValueCallback1, $stringKeyValueCallback2));
