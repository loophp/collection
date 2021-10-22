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

/** @var EntityManagerInterface $em */
$q = $em->createQuery('SELECT u FROM MyProject\Model\Product p');

$isBook = static fn($product): bool => 'books' === $product->category;
$isScreencast = static fn($product): bool => 'screencasts' === $product->category;

$divisibleBy3 = static fn ($value): bool => 0 === $value % 3;

$collection = Collection::fromIterable($q->toIterable())
                        ->find(null, $isBook);

$collection = Collection::fromIterable(range(1, 10))
                        ->filter($isBook, $isScreencast);

$collection = Collection::fromIterable(range(1, 10))
                        ->find($divisibleBy3); // 3
