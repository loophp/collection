<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

use function range;

include __DIR__ . '/../../../../vendor/autoload.php';

$divisibleBy3 = static fn ($value): bool => 0 === $value % 3;

// Example 1: find a value and use the default `null` if not found
$value = Collection::fromIterable(range(1, 10))
    ->find($divisibleBy3); // 3

$value = Collection::fromIterable([1, 2, 4])
    ->find($divisibleBy3); // null

$value = Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])
    ->find(static fn ($value): bool => 'b' === $value); // 'b'

$value = Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])
    ->find(static fn ($value): bool => 'x' === $value); // null

// Example 2: find a value and use a custom default if not found
$value = Collection::fromIterable([1, 2, 4])
    ->find(-1, $divisibleBy3); // -1

$value = Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])
    ->find(404, static fn ($value): bool => 'x' === $value); // 404

// Example 3: use with a Doctrine Query
/** @var EntityManagerInterface $em */
$q = $em->createQuery('SELECT u FROM MyProject\Model\Product p');

$isBook = static fn ($product): bool => 'books' === $product->getCategory();

$value = Collection::fromIterable($q->toIterable())
    ->find(null, $isBook);
