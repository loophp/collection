<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @psalm-param CollectionInterface<int<0, 2>, 1|2|3> $collection
 *
 * @phpstan-param CollectionInterface<int, int> $collection
 */
function filter_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function filter_checkMap(CollectionInterface $collection): void
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

filter_checkList(Collection::fromIterable([1, 2, 3])->filter());
filter_checkList(Collection::fromIterable([1, 2, 3])->filter($intValueCallback));
filter_checkList(Collection::fromIterable([1, 2, 3])->filter($intValueCallback, $intValueCallback2));
filter_checkList(Collection::fromIterable([1, 2, 3])->filter($intKeyValueCallback1));
filter_checkList(Collection::fromIterable([1, 2, 3])->filter($intKeyValueCallback1, $intKeyValueCallback2));

filter_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => ''])->filter());
filter_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => ''])->filter($stringValueCallback));
filter_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => ''])->filter($stringValueCallback, $stringValueCallback2));
filter_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => ''])->filter($stringKeyValueCallback1));
filter_checkMap(Collection::fromIterable(['foo' => 'bar', 'baz' => ''])->filter($stringKeyValueCallback1, $stringKeyValueCallback2));
