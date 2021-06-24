<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

/** @var EntityManagerInterface $em */
$q = $em->createQuery('SELECT u FROM MyProject\Model\User u');

// 1. Injecting the query resultset in a collection
$collection = Collection::fromIterable($q->toIterable());

// 2. Using a criteria
$collection = Collection::fromIterable($q->toIterable())
    ->matching(
        Criteria::create()
            ->where(
                Criteria::expr()
                    ->eq('isActive', true)
            )
    );
