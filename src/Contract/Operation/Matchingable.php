<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Doctrine\Common\Collections\Criteria;
use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Matchingable
{
    /**
     * Collection lets you use the Criteria API provided by Doctrine Collections, but in a lazy way.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#matching
     *
     * @return Collection<TKey, T>
     */
    public function matching(Criteria $criteria): Collection;
}
