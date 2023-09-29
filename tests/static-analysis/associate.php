<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function associate_checkIntInt(CollectionInterface $collection): void {}
/**
 * @psalm-param CollectionInterface<non-empty-string, non-empty-string> $collection
 *
 * @phpstan-param CollectionInterface<string, string> $collection
 */
function associate_checkStringString(CollectionInterface $collection): void {}
/**
 * @psalm-param CollectionInterface<non-empty-string, bool> $collection
 *
 * @phpstan-param CollectionInterface<string, bool> $collection
 */
function associate_checkStringBool(CollectionInterface $collection): void {}

$square = static fn (int $val): int => $val ** 2;
$toBoldString = static fn (int $val): string => sprintf('*%s*', $val);
$isEven = static fn (int $val): bool => 0 === $val % 2;

associate_checkIntInt(Collection::fromIterable([1, 2, 3])->associate($square, $square));
associate_checkStringString(Collection::fromIterable([1, 2, 3])->associate($toBoldString, $toBoldString));
associate_checkStringBool(Collection::fromIterable([1, 2, 3])->associate($toBoldString, $isEven));
