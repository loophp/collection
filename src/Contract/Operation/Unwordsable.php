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
interface Unwordsable
{
    /**
     * Opposite of `words` and similar to `unlines`, creates a single string
     * from multiple strings using one space as the glue.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#unwords
     *
     * @return Collection<TKey, string>
     */
    public function unwords(): Collection;
}
