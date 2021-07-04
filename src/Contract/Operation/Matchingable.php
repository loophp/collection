<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

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
     * @return Collection<TKey, T>
     */
    public function matching(Criteria $criteria): Collection;
}
