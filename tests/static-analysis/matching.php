<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use Doctrine\Common\Collections\Criteria;
use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @psalm-param CollectionInterface<int<0, 2>, 1|2|3> $collection
 *
 * @phpstan-param CollectionInterface<int, int> $collection
 */
function matching_checkList(CollectionInterface $collection): void {}

/**
 * @param CollectionInterface<string, string> $collection
 */
function matching_checkMap(CollectionInterface $collection): void {}

$criteria = Criteria::create()->where(Criteria::expr()->gt('age', 18));

matching_checkList(Collection::fromIterable([1, 2, 3])->matching($criteria));
matching_checkList(Collection::fromIterable([1, 2, 3])->matching($criteria)->matching($criteria));

matching_checkMap(Collection::fromIterable(['foo' => 'bar'])->matching($criteria));
matching_checkMap(Collection::fromIterable(['foo' => 'bar'])->matching($criteria)->matching($criteria));
