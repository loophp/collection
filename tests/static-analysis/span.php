<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @phpstan-param CollectionInterface<int, Collection<int, int>> $collection
 *
 * @psalm-param CollectionInterface<int, Collection<int<0, 2>, 2|3|4>> $collection
 */
function span_checkListCollectionInt(CollectionInterface $collection): void {}
/**
 * @phpstan-param CollectionInterface<int, int> $collection
 *
 * @psalm-param CollectionInterface<int<0, 2>, 2|3|4> $collection
 */
function span_checkListInt(CollectionInterface $collection): void {}
/**
 * @param CollectionInterface<int, Collection<string, string>> $collection
 */
function span_checkMapCollectionString(CollectionInterface $collection): void {}
/**
 * @param CollectionInterface<string, string> $collection
 */
function span_checkMapString(CollectionInterface $collection): void {}

$intValueCallback = static fn (int $value): bool => $value % 2 === 0;
$intSecondCallback = static fn (int $value): bool => 3 > $value;
$stringValueCallback = static fn (string $value): bool => 'bar' === $value;
$stringSecondCallback = static fn (string $value): bool => 'foo' === $value;

span_checkListCollectionInt(Collection::fromIterable([2, 3, 4])->span($intValueCallback));
span_checkListCollectionInt(Collection::fromIterable([2, 3, 4])->span($intValueCallback, $intSecondCallback));
span_checkMapCollectionString(Collection::fromIterable(['foo' => 'bar', 'bar' => 'foo'])->span($stringValueCallback));
span_checkMapCollectionString(Collection::fromIterable(['foo' => 'bar', 'bar' => 'foo'])->span($stringValueCallback, $stringSecondCallback));

[$left, $right] = Collection::fromIterable([2, 3, 4])->span($intValueCallback)->all();
span_checkListInt($left);
span_checkListInt($right);

$first = Collection::fromIterable([2, 3, 4])->span($intValueCallback)->first(Collection::empty());
$last = Collection::fromIterable([2, 3, 4])->span($intValueCallback)->last(Collection::empty());
span_checkListInt($first);
span_checkListInt($last);

// VALID failures -> current returns T|null

[$left, $right] = Collection::fromIterable(['foo' => 'bar', 'bar' => 'foo'])->span($stringValueCallback)->all();
span_checkMapString($left);
span_checkMapString($right);

$first = Collection::fromIterable(['foo' => 'bar', 'bar' => 'foo'])->span($stringValueCallback)->first(Collection::empty());
$last = Collection::fromIterable(['foo' => 'bar', 'bar' => 'foo'])->span($stringValueCallback)->last(Collection::empty());
span_checkMapString($first);
span_checkMapString($last);
