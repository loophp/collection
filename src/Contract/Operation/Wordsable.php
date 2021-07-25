<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Wordsable
{
    /**
     * Get a list of words from a string, splitting based on the character set: \t, \n, ' '.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#words
     *
     * @return Collection<TKey, string>
     */
    public function words(): Collection;
}
